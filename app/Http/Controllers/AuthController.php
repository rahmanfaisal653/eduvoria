<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /* =========================
        LOGIN
    ========================== */

    public function showLogin()
    {
        return view('auth.login');
    }

    public function processLogin(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // Ambil user berdasarkan email
        $user = User::where('email', $credentials['email'])->first();

        // Jika akun diblokir
        if ($user && strtolower(trim($user->status)) === 'blocked') {
            return back()->withErrors([
                'email' => 'Akun Anda telah diblokir. Silakan hubungi admin.'
            ])->withInput($request->only('email'));
        }

        // Proses login (cek user ada, password benar, status active)
        if (!Auth::attempt([
            'email' => $credentials['email'],
            'password' => $credentials['password'],
            'status' => 'active'
        ])) {
            return back()->withErrors([
                'email' => 'Email atau password salah.'
            ])->withInput($request->only('email'));
        }

        // Regenerate session (security)
        $request->session()->regenerate();

        // Redirect berdasarkan role
        if (Auth::user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        return redirect()->intended('/homepage');
    }

    /* =========================
        REGISTER
    ========================== */

    public function showRegister()
    {
        return view('auth.register');
    }

    public function processRegister(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role'     => 'user',
            'status'   => 'active' 
        ]);

        Auth::login($user);

        return redirect('/homepage');
    }

    /* =========================
        LOGOUT
    ========================== */

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
