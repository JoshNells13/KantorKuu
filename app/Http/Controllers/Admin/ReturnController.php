<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\ActivityLog;
use App\Models\Borrowing;
use App\Models\ReturnTool;
use App\Services\ActivityLogService;
use Carbon\Carbon as CarbonAlias;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class ReturnController extends Controller
{

    protected $activityLogService;

    public function __construct(ActivityLogService $activityLogService)
    {
        $this->activityLogService = $activityLogService;
    }

    public function index()
    {
        return view('Admin.ReturnTool.index', [
            'returns' => ReturnTool::with('borrowing.tool', 'borrowing.user')->get()
        ]);
    }

    // public function create(Borrowing $borrowing)
    // {
    //     $borrowing->load(['user', 'tool']);

    //     return view('Admin.ReturnTool.create', compact('borrowing'));
    // }


    public function store(Request $request, Borrowing $borrowing)
    {
        // This acts as "Approval" for the return
        // Borrowing already has a ReturnTool record created by the Borrower
        $returnTool = $borrowing->returnTool;

        if (!$returnTool) {
            // Backup case if peminjam didn't submit correctly or it's a direct return by admin
            $returnTool = ReturnTool::create([
                'borrowing_id' => $borrowing->id,
                'returned_at' => Carbon::now(),
                'fine' => 0,
                'return_condition' => 'Tidak Diketahui'
            ]);
        }

        $dueDate = Carbon::parse($borrowing->return_date);
        $returnedDate = Carbon::now();

        $lateDays = $returnedDate->greaterThan($dueDate)
            ? $dueDate->diffInDays($returnedDate)
            : 0;

        $fine = $lateDays * 5000;

        $returnTool->update([
            'fine' => $fine,
            'returned_at' => $returnedDate
        ]);

        $qty = $borrowing->qty ?? 1;
        $borrowing->tool->increment('stock', $qty);

        $this->activityLogService->log(Auth::id(), "Menyetujui pengembalian alat: {$borrowing->tool->name}");

        $borrowing->update(['status' => 'dikembalikan']);

        return redirect()
            ->route('admin.borrowings.index')
            ->with('success', "Pengembalian berhasil disetujui! Stok Barang Menjadi {$borrowing->tool->stock}");
    }



    public function edit(ReturnTool $returnTool)
    {
        return view('Admin.ReturnTool.edit', [
            'return' => $returnTool
        ]);
    }

    public function update(Request $request, ReturnTool $returnTool)
    {
        $request->validate([
            'returned_at' => 'required|date',
            'return_condition' => 'required',
        ]);

        $dueDate = Carbon::parse($returnTool->borrowing->return_date);
        $returnedDate = Carbon::parse($request->returned_at);

        $lateDays = $returnedDate->greaterThan($dueDate)
            ? $dueDate->diffInDays($returnedDate)
            : 0;

        $returnTool->update([
            'returned_at' => $request->returned_at,
            'return_condition' => $request->return_condition,
        ]);

        $this->activityLogService->log(Auth::id(), "Memperbarui data pengembalian alat: {$returnTool->borrowing->tool->name}");

        return redirect()->route('admin.return-tools.index')->with('success', 'Data pengembalian berhasil diperbarui!');
    }

    public function destroy(ReturnTool $returnTool)
    {
        $returnTool->delete();

        $this->activityLogService->log(Auth::id(), "Menghapus data pengembalian alat: {$returnTool->borrowing->tool->name}");

        return back()->with('success', 'Data pengembalian berhasil dihapus!');
    }
}
