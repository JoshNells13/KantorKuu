<?php

namespace App\Http\Controllers;

use App\Models\Borrowing;
use App\Models\ReturnTool;
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

        $lateDays = Carbon::parse($request->returned_at)
            ->diffInDays($borrowing->return_date, false);

        $fine = $lateDays < 0 ? abs($lateDays) * 5000 : 0;

        ReturnTool::create([
            'borrowing_id' => $borrowing->id,
            'returned_at'  => $request->returned_at,
        ]);

        $borrowing->update(['status' => 'dikembalikan']);
        $borrowing->tool->update(['condition' => $request->condition]);
        $borrowing->tool->increment('stock');

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

        return redirect()->route('admin.return-tools.index')->with('success', 'Data pengembalian berhasil diperbarui!');
    }

    public function destroy(ReturnTool $returnTool)
    {
        $returnTool->delete();
        return back();
    }
}
