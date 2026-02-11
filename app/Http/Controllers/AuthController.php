<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('Auth.Login');
    }

    public function showRegister()
    {
        return view('Auth.Register');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $role = Auth::user()->role->name;

            if ($role === 'admin') {
                return redirect()->route('admin.dashboard')->with('success', 'Login berhasil!');
            } elseif ($role === 'petugas') {
                return redirect()->route('petugas.dashboard')->with('success', 'Login berhasil!');
            }

            return redirect()->route('peminjam.dashboard')->with('success', 'Login berhasil!');
        }

        return back()->withErrors([
            'username' => 'username atau password salah'
        ]);
    }

    public function register(Request $request)
    {
        $request->validate([
            'name'     => 'required',
            'username' => 'required|unique:users',
            'password' => 'required|min:6'
        ]);

        User::create([
            'name'     => $request->name,
            'username' => $request->username,
            'password' => bcrypt($request->password),
            'role_id'  => Role::where('name', 'peminjam')->first()->id
        ]);

        return redirect()->route('login.show')->with('success', 'Registrasi berhasil! Silakan login.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login.show')->with('success', 'Logout berhasil!') ;
    }
}
