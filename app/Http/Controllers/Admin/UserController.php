<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {


        return view('Admin.User.index', [
            'users' => User::with('role')->get()
        ]);
    }

    public function create()
    {

        $roles = Role::where('name', '!=', 'admin')->get();

        return view('Admin.User.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required',
            'username' => 'required|unique:users',
            'password' => 'required|min:6',
            'role_id'  => 'required'
        ]);

        User::create([
            'name'     => $request->name,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'role_id'  => $request->role_id
        ]);

        return redirect()->route('users.index')->with('success', 'User berhasil ditambahkan');
    }

    public function edit(User $user)
    {
        return view('Admin.User.edit', [
            'user'  => $user,
            'roles' => Role::all()
        ]);
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name'     => 'required',
            'username' => 'required|unique:users,username,' . $user->id,
            'role_id'  => 'required'
        ]);

        $data = [
            'name'     => $request->name,
            'username' => $request->username,
            'role_id'  => $request->role_id
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('users.index')->with('success', 'User berhasil diperbarui');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return back()->with('success', 'User berhasil dihapus');
    }
}
