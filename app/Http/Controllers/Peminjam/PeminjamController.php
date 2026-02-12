<?php

namespace App\Http\Controllers\Peminjam;

use App\Http\Controllers\Controller;
use App\Models\Borrowing;
use App\Models\ReturnTool;
use App\Models\Tool;
use App\Services\ActivityLogService;
use App\Services\StockService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PeminjamController extends Controller
{
    protected $stockService;
    protected $activityLogService;

    public function __construct(StockService $stockService, ActivityLogService $activityLogService)
    {
        $this->stockService = $stockService;
        $this->activityLogService = $activityLogService;
    }

    public function Tool()
    {
        $Tool = Tool::all();
        return view('Peminjam.Tool.index', compact('Tool'));
    }

    public function ShowTool(Tool $tool)
    {
        return view('Peminjam.Tool.show', compact('tool'));
    }

    public function Borrowing()
    {
        $tools = Tool::all();
        $borrowings = Borrowing::with('tool', 'returnTool')->latest()
            ->where('user_id', Auth::id())
            ->get();

        return view('Peminjam.Borrowing.index', compact('borrowings', 'tools'));
    }

    public function CreateBorrowing(Request $request)
    {
        // Get tool_id from query parameter if provided
        $toolId = $request->query('tool_id');
        $selectedTool = null;
        
        if ($toolId) {
            $selectedTool = Tool::find($toolId);
        }
        
        return view('Peminjam.Borrowing.create', compact('selectedTool'));
    }

    public function StoreBorrowing(Request $request)
    {
        $request->validate([
            'tool_id'     => 'required',
            'return_date' => 'required|date',
            'qty'         => 'required|integer|min:1',
        ]);

        $userId = Auth::id();
        $qty = $request->qty ?? 1;

        if (!$this->stockService->checkStock($request->tool_id, $qty)) {
            return back()->with('error', 'Stok alat tidak mencukupi!');
        }

        Borrowing::create([
            'user_id'     => $userId,
            'tool_id'     => $request->tool_id,
            'borrow_date' => now(),
            'return_date' => $request->return_date,
            'status'      => $request->status ?? 'menunggu',
            'qty'         => $qty,
        ]);

        $tool = Tool::find($request->tool_id);
        $this->activityLogService->log($userId, "Meminjam alat: {$tool->name}");

        return redirect()->route('peminjam.borrowings.index')->with('success', 'Peminjaman berhasil diajukan!');
    }

    public function returnTool()
    {
        $returns = ReturnTool::with('borrowing.tool')
            ->whereHas('borrowing', function ($query) {
                $query->where('user_id', Auth::id());
            })
            ->get();

        return view('Peminjam.Return.index', compact('returns'));
    }

    public function returnCreate()
    {
        return view('Peminjam.Return.create');
    }

    public function storeReturnTool(Request $request, Borrowing $borrowing)
    {
        // Update borrowing status
        $borrowing->update(['status' => 'dikembalikan']);

        // Tambah stok alat
        $qty = $borrowing->qty ?? 1;
        $this->stockService->incrementStock($borrowing->tool_id, $qty);

        $dueDate = Carbon::parse($borrowing->return_date);
        $returnedDate = Carbon::now();

        $lateDays = $returnedDate->greaterThan($dueDate)
            ? $dueDate->diffInDays($returnedDate)
            : 0;

        $fine = $lateDays * 5000;

        ReturnTool::create([
            'borrowing_id' => $borrowing->id,
            'returned_at'  => $returnedDate,
            'fine'         => $fine
        ]);

        $this->activityLogService->log(Auth::id(), "Mengembalikan alat: {$borrowing->tool->name}");

        return redirect()
            ->route('peminjam.borrowings.index')
            ->with('success', "Pengembalian alat berhasil diproses! Jumlah Barang Menjadi {$borrowing->tool->stock}");
    }
}
