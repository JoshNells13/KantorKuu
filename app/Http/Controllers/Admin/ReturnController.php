<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\ActivityLog;
use App\Models\Borrowing;
use App\Models\ReturnTool;
use Carbon\Carbon as CarbonAlias;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class ReturnController extends Controller
{

    public function index()
    {
        return view('Admin.ReturnTool.index', [
            'returns' => ReturnTool::with('borrowing.tool', 'borrowing.user')->get()
        ]);
    }

    public function create(Borrowing $borrowing)
    {
        $borrowing->load(['user', 'tool']);

        return view('Admin.ReturnTool.create', compact('borrowing'));
    }


    public function store(Request $request, Borrowing $borrowing)
    {
        $request->validate([
            'returned_at' => 'required|date',
        ]);

        $dueDate = Carbon::parse($borrowing->return_date);
        $returnedDate = Carbon::parse($request->returned_at);

        $lateDays = $returnedDate->greaterThan($dueDate)
            ? $dueDate->diffInDays($returnedDate)
            : 0;

        $fine = $lateDays * 5000;

        ReturnTool::create([
            'borrowing_id' => $borrowing->id,
            'returned_at'  => Carbon::now(),
            'fine'         => $fine
        ]);

        $borrowing->update(['status' => 'dikembalikan']);
        $borrowing->tool->increment('stock');

        ActivityLog::create([
            'user_id' => Auth::id(),
            'activity'  => "Mengembalikan alat: {$borrowing->tool->name}"
        ]);

        return redirect()
            ->route('admin.borrowings.index')
            ->with('success', 'Pengembalian berhasil diproses');
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
        ]);

        $returnTool->update([
            'returned_at' => $request->returned_at,
        ]);

        ActivityLog::create([
            'user_id' => Auth::id(),
            'activity'  => "Mengembalikan alat: {$returnTool->borrowing->tool->name}"
        ]);

        return redirect()->route('admin.return-tools.index')->with('success', 'Data pengembalian berhasil diperbarui!');
    }

    public function destroy(ReturnTool $returnTool)
    {
        $returnTool->delete();

        ActivityLog::create([
            'user_id' => Auth::id(),
            'activity'  => "Menghapus data pengembalian alat: {$returnTool->borrowing->tool->name}"
        ]);

        return back();
    }
}
