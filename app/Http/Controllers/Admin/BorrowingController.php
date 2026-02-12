<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\ActivityLog;
use App\Models\Borrowing;
use App\Models\Tool;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BorrowingController extends Controller
{
    public function index()
    {
        $borrowings = Borrowing::with('user', 'tool', 'returnTool')->get();

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
            'user_id'     => 'required'
        ]);


        $status = (Auth::user()->role_id == 1 || Auth::user()->role_id == 2) ? $request->status ?? 'menunggu' : 'menunggu';

        // Check stock
        $tool = Tool::find($request->tool_id);
        if ($tool->stock < 1) {
            return back()->with('error', 'Stok alat habis!');
        }

        ActivityLog::create([
            'user_id' => $request->user_id,
            'activity'  => "Meminjam alat: {$tool->name}"
        ]);

        Borrowing::create([
            'user_id'     => $request->user_id,
            'tool_id'     => $request->tool_id,
            'borrow_date' => now(),
            'return_date' => $request->return_date,
            'status'      => $status,
            'qty'        => $request->qty ?? 1
        ]);


        return redirect()->route('admin.borrowings.index')->with('success', 'Peminjaman berhasil diajukan!');
    }

    public function approve(Borrowing $borrowing)
    {
        $borrowing->update(['status' => 'dipinjam']);

        // Decrease stock

        ActivityLog::create([
            'user_id' => Auth::id(),
            'activity'  => "Meminjam alat: {$borrowing->tool->name}"
        ]);

        $Qty = $borrowing->qty ?? 1;

        $borrowing->tool->decrement('stock', $Qty);




        return redirect()->route('admin.borrowings.index')->with('success', "Peminjaman berhasil disetujui!, Stok Berkurang Menjadi {$borrowing->tool->stock}");
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

        // Hitung selisih
        $difference = $newQty - $oldQty;

        if ($difference > 0) {
            // Qty bertambah → stok harus dikurangi
            if ($tool->stock < $difference) {
                return back()->withErrors(['qty' => 'Stok tidak mencukupi']);
            }

            $tool->decrement('stock', $difference);
        } elseif ($difference < 0) {
            // Qty berkurang → stok harus ditambah
            $tool->increment('stock', abs($difference));
        }

        // Update data
        $borrowing->update([
            'borrow_date' => $request->borrow_date,
            'return_date' => $request->return_date,
            'status'      => $request->status,
            'qty'         => $newQty
        ]);

        ActivityLog::create([
            'user_id' => Auth::id(),
            'activity' => "Memperbarui peminjaman alat: {$tool->name}"
        ]);

        return redirect()
            ->route('admin.borrowings.index')
            ->with('success', 'Data peminjaman berhasil diperbarui!');
    }



    public function destroy(Borrowing $borrowing)
    {
        $borrowing->delete();

        ActivityLog::create([
            'user_id' => Auth::id(),
            'activity'  => "Menghapus peminjaman alat: {$borrowing->tool->name}"
        ]);

        return redirect()->route('admin.borrowings.index')->with('success', 'Data peminjaman berhasil dihapus!');
    }
}
