<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Borrowing;
use App\Models\Tool;
use App\Models\User;
use App\Services\ActivityLogService;
use App\Services\StockService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BorrowingController extends Controller
{
    protected $stockService;
    protected $activityLogService;

    public function __construct(StockService $stockService, ActivityLogService $activityLogService)
    {
        $this->stockService = $stockService;
        $this->activityLogService = $activityLogService;
    }

    public function index()
    {
        $borrowings = Borrowing::with('user', 'tool', 'returnTool')->where('status', '!=', 'dikembalikan')->get();
        return view('Admin.Borrowing.index', compact('borrowings'));
    }

    public function create()
    {
        $tools = Tool::all();
        $users = User::where('role_id', 1)->get();
        return view('Admin.Borrowing.create', compact('users', 'tools'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tool_id'     => 'required',
            'return_date' => 'required|date',
            'user_id'     => 'required',
            'qty'         => 'sometimes|integer|min:1'
        ]);

        $qty = $request->qty ?? 1;

        if (!$this->stockService->checkStock($request->tool_id, $qty)) {
            return back()->with('error', 'Stok alat habis atau tidak mencukupi!');
        }

        $status = (Auth::user()->role_id == 1 || Auth::user()->role_id == 2) ? $request->status ?? 'menunggu' : 'menunggu';

        $tool = Tool::find($request->tool_id);

        $this->activityLogService->log($request->user_id, "Meminjam alat: {$tool->name}");

        Borrowing::create([
            'user_id'     => $request->user_id,
            'tool_id'     => $request->tool_id,
            'borrow_date' => now(),
            'return_date' => $request->return_date,
            'status'      => $status,
            'qty'         => $qty
        ]);

        return redirect()->route('admin.borrowings.index')->with('success', 'Peminjaman berhasil diajukan!');
    }

    public function approve(Borrowing $borrowing)
    {
        $qty = $borrowing->qty ?? 1;

        if (!$this->stockService->checkStock($borrowing->tool_id, $qty)) {
            return back()->with('error', 'Stok tidak mencukupi untuk menyetujui peminjaman ini.');
        }

        $borrowing->update(['status' => 'dipinjam']);

        $this->stockService->decrementStock($borrowing->tool_id, $qty);

        $this->activityLogService->log(Auth::id(), "Menyetujui peminjaman alat: {$borrowing->tool->name}");

        return redirect()->route('admin.borrowings.index')->with('success', "Peminjaman berhasil disetujui!, Stok Berkurang.");
    }

    public function edit(Borrowing $borrowing)
    {
        return view('Admin.Borrowing.edit', [
            'borrowing' => $borrowing,
            'tools' => Tool::all(),
            'users' => User::where('role_id', 1)->get()
        ]);
    }

    public function update(Request $request, Borrowing $borrowing)
    {
        if ($borrowing->status === 'dikembalikan') {
            return redirect()
                ->route('admin.borrowings.index')
                ->with('error', 'Data yang sudah dikembalikan tidak bisa diedit.');
        }

        $request->validate([
            'borrow_date' => 'required|date',
            'return_date' => 'required|date',
            'status'      => 'required',
            'qty'         => 'required|integer|min:1'
        ]);

        $tool = $borrowing->tool;
        $oldQty = $borrowing->qty;
        $newQty = $request->qty;
        $difference = $newQty - $oldQty;

        if ($difference > 0) {
            if (!$this->stockService->checkStock($tool->id, $difference)) {
                return back()->withErrors(['qty' => 'Stok tidak mencukupi']);
            }
            $this->stockService->decrementStock($tool->id, $difference);
        } elseif ($difference < 0) {
            $this->stockService->incrementStock($tool->id, abs($difference));
        }

        $borrowing->update([
            'borrow_date' => $request->borrow_date,
            'return_date' => $request->return_date,
            'status'      => $request->status,
            'qty'         => $newQty
        ]);

        $this->activityLogService->log(Auth::id(), "Memperbarui peminjaman alat: {$tool->name}");

        return redirect()
            ->route('admin.borrowings.index')
            ->with('success', 'Data peminjaman berhasil diperbarui!');
    }

    public function destroy(Borrowing $borrowing)
    {
        $borrowing->delete();

        $this->activityLogService->log(Auth::id(), "Menghapus peminjaman alat: {$borrowing->tool->name}");

        return redirect()->route('admin.borrowings.index')->with('success', 'Data peminjaman berhasil dihapus!');
    }
}
