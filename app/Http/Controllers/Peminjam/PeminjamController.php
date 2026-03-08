<?php

namespace App\Http\Controllers\Peminjam;

use App\Http\Controllers\Controller;
use App\Models\Borrowing;
use App\Models\Category;
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

    public function Tool(Request $request)
    {
        $query = Tool::query();

        $Category = Category::all();

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%')
                ->orWhereHas('category', function ($q) use ($request) {
                    $q->where('name', 'like', '%' . $request->search . '%');
                });
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        $tools = $query->get();

        return view('Peminjam.Tool.index', compact('tools', 'Category'));
    }

    public function Borrowing()
    {
        $tools = Tool::all();
        $borrowings = Borrowing::with('tool', 'returnTool')->latest()
            ->where('user_id', Auth::id())
            ->where('status', '!=', 'dikembalikan')
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

        $tool = Tool::find($request->tool_id);

        $totalPrice = $tool->price_per_day * $qty * now()->diffInDays($request->return_date);

        Borrowing::create([
            'user_id'     => $userId,
            'tool_id'     => $request->tool_id,
            'borrow_date' => now(),
            'return_date' => $request->return_date,
            'status'      => $request->status ?? 'menunggu',
            'qty'         => $qty,
            'total_price' => $totalPrice,
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
        $request->validate([
            'return_condition' => 'required|string',
        ]);

        // Don't increment stock yet, wait for approval
        // Create ReturnTool entry (or update if needed)
        ReturnTool::create([
            'borrowing_id'     => $borrowing->id,
            'returned_at'      => Carbon::now(),
            'fine'             => 0, // Admin will finalize fine? 
            'return_condition' => $request->return_condition,
        ]);

        $borrowing->update(['status' => 'menunggu_kembali']);

        $this->activityLogService->log(Auth::id(), "Mengajukan pengembalian alat: {$borrowing->tool->name}");

        return redirect()
            ->route('peminjam.borrowings.index')
            ->with('success', "Pengembalian alat berhasil diajukan! Menunggu verifikasi petugas.");
    }
}
