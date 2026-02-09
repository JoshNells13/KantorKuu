<?php

namespace App\Http\Controllers;

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
            'return_date' => 'required|date'
        ]);

        $userId = Auth::id();
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


        return redirect()->route('admin.borrowings.index')->with('success', 'Peminjaman berhasil diajukan!');
    }

    public function approve(Borrowing $borrowing)
    {
        $borrowing->update(['status' => 'dipinjam']);

        // Decrease stock
        $borrowing->tool->decrement('stock');

        return back();
    }


    public function edit(Borrowing $borrowing)
    {


        return view('Admin.Borrowing.edit', [
            'borrowing' => $borrowing,
            'tools' => Tool::all(),
            'users' => User::where('role_id', 3)->get()
        ]);
    }

    public function update(Request $request, Borrowing $borrowing)
    {
        $request->validate([
            'tool_id'     => 'required',
            'return_date' => 'required|date'
        ]);

        $data = [
            'tool_id'     => $request->tool_id,
            'return_date' => $request->return_date,
            'user_id'     => $request->user_id,
            'status'      => $request->status
        ];

        $borrowing->update($data);

        return redirect()->route('admin.borrowings.index');
    }

    public function destroy(Borrowing $borrowing)
    {
        $borrowing->delete();
        return back();
    }
}
