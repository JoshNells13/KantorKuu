<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;

use App\Models\ActivityLog;
use App\Models\Borrowing;
use App\Models\ReturnTool;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PetugasController extends Controller
{
    public function index()
    {

        $borrowings = Borrowing::with(['user', 'tool'])->get();

        return view('Petugas.ReturnTool.index', compact('borrowings'));
    }

    public function approve(Borrowing $borrowing)
    {
        $borrowing->update(['status' => 'dipinjam']);
        // Decrease stock
        $borrowing->tool->decrement('stock');


        return redirect()->route('petugas.borrowings.index')->with('success', 'Peminjaman alat disetujui dan stok berhasil dikurangi! Menjadi '.$borrowing->tool->stock );
    }

    public function returnTool(Borrowing $borrowing)
    {
        $borrowing->load(['user', 'tool']);

        return view('Petugas.ReturnTool.create', compact('borrowing'));
    }

    public function storeReturnTool(Request $request, Borrowing $borrowing)
    {


        // Update borrowing status
        $borrowing->update(['status' => 'dikembalikan']);

        // Tambah stok alat
        $borrowing->tool->increment('stock');


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

        ActivityLog::create([
            'user_id' => Auth::id(),
            'activity'  => "Mengembalikan alat: {$borrowing->tool->name}"
        ]);

        return redirect()->route('petugas.borrowings.index')->with('success', 'Pengembalian alat berhasil diproses!');
    }
}
