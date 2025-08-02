<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class AuthController extends Controller
{
    //

    public function loginproses(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');
        $remember = $request->filled('remember'); // <--- ini kunci pentingnya!

        if (Auth::attempt($credentials, $remember)) { // <-- tambahkan $remember di sini
            $user = Auth::user();

            if (Gate::allows('admin')) {
                return redirect()->route('Dashboard')->with('success', 'Berhasil login sebagai Admin'.', '. $user->username);
            }

            Auth::logout();
            return redirect()->back()->with('error', 'Role tidak dikenali');
        }

        return redirect()->back()->with('error', 'Email atau password salah');

    }

     // Menangani proses logout
    public function logout()
    {
        Auth::logout();
        return redirect('Login');
    }
}
