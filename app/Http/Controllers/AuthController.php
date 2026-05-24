<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (session('user')) {
            $user = (object) session('user');
            return redirect($user->role === 'Admin' ? '/admin/dashboard' : '/mahasiswa/dashboard');
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'nama_user' => 'required',
            'password' => 'required',
        ]);

        $users = DB::select("SELECT * FROM users WHERE nama_user = ?", [$request->nama_user]);

        if (count($users) > 0 && Hash::check($request->password, $users[0]->password)) {
            session(['user' => $users[0]]);

            if ($users[0]->role === 'Admin') {
                return redirect('/admin/dashboard');
            }
            return redirect('/mahasiswa/dashboard');
        }

        return back()->with('error', 'Nama user atau password salah.');
    }

    public function logout()
    {
        session()->flush();
        return redirect('/login');
    }
}
