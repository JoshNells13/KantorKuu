<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Borrowing;
use App\Models\ReturnTool;
use App\Models\Tool;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PeminjamController extends Controller
{
    public function Tool()
    {

        $Tool = Tool::all();

        return view('Peminjam.Tool.index', compact('Tool'));
    }

    public function Borrowing()
    {
        $tools = Tool::all();

        $borrowings = Borrowing::with('tool', 'returnTool')
            ->where('user_id', Auth::id())
            ->get();



        return view('Peminjam.Borrowing.index', compact('borrowings', 'tools'));
    }



    public function CreateBorrowing()
    {
        $tools = Tool::all();

        return view('Peminjam.Borrowing.create', compact('tools'));
    }


    public function StoreBorrowing(Request $request)
    {

        $request->validate([
            'tool_id'     => 'required',
            'return_date' => 'required|date'
        ]);

        $userId = Auth::user()->id;

        $status = (Auth::user()->role_id == 1 || Auth::user()->role_id == 2) ? $request->status ?? 'menunggu' : 'menunggu';

        // Check stock
        $tool = Tool::find($request->tool_id);
        if ($tool->stock < 1) {
            return back()->with('error', 'Stok alat habis!');
        }


        $tool->decrement('stock');

        Borrowing::create([
            'user_id'     => $userId,
            'tool_id'     => $request->tool_id,
            'borrow_date' => now(),
            'return_date' => $request->return_date,
            'status'      => $status
        ]);

        ActivityLog::create([
            'user_id' => $userId,
            'action'  => "Meminjam alat: {$tool->name}"
        ]);


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
        $borrowing->tool->increment('stock');

        // Simpan data pengembalian
        ReturnTool::create([
            'borrowing_id' => $borrowing->id,
            'returned_at' => Carbon::now(),
        ]);

        ActivityLog::create([
            'user_id' => Auth::id(),
            'action'  => "Mengembalikan alat: {$borrowing->tool->name}"
        ]);

        return redirect()
            ->route('peminjam.borrowings.index')
            ->with('success', 'Pengembalian alat berhasil diproses!');
    }
}
