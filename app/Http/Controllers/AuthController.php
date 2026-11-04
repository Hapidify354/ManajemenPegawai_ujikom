<?php

namespace App\Http\Controllers;

// ==================================================
// BAGIAN 1: IMPORT DAN DEPENDENSI
// ==================================================

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

// ==================================================
// BAGIAN 2: CONTROLLER AUTENTIKASI
// ==================================================

class AuthController extends Controller
{
    // ==================================================
    // BAGIAN 3: MENAMPILKAN HALAMAN LOGIN
    // ==================================================

    public function showLogin(): View
    {
        return view('auth.login');
    }

    // ==================================================
    // BAGIAN 4: PROSES LOGIN
    // ==================================================

    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'username' => ['required', 'string', 'max:50'],
            'password' => ['required', 'string'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->route('dashboard');
        }

        return back()
            ->withErrors([
                'username' => 'Username atau password salah.',
            ])
            ->onlyInput('username');
    }

    // ==================================================
    // BAGIAN 5: PROSES LOGOUT
    // ==================================================

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
