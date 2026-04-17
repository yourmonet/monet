<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class AnggotaAuthController extends Controller
{
    // ─────────────────── LOGIN ───────────────────

    public function showLogin(): View|RedirectResponse
    {
        if (Auth::check() && Auth::user()->role === 'anggota') {
            return redirect('/user/dashboard');
        }
        return view('user.login');
    }

    public function login(Request $request): RedirectResponse
    {
        $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $user = Auth::user();

            if ($user->role !== 'anggota') {
                Auth::logout();
                return back()->withErrors([
                    'email' => 'Akun ini bukan akun anggota. Silakan gunakan halaman login yang sesuai.',
                ])->withInput($request->except('password'));
            }

            $request->session()->regenerate();
            return redirect('/user/dashboard');
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->withInput($request->except('password'));
    }

    // ─────────────────── REGISTER ───────────────────

    public function showRegister(): View|RedirectResponse
    {
        if (Auth::check() && Auth::user()->role === 'anggota') {
            return redirect('/user/dashboard');
        }
        return view('user.register');
    }

    public function register(Request $request): RedirectResponse
    {
        $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'anggota',
        ]);

        return redirect('/user/login')->with('success', 'Akun berhasil dibuat. Silakan login.');
    }

    // ─────────────────── DASHBOARD ───────────────────

    public function dashboard(): View
    {
        return view('user.dashboard');
    }

    // ─────────────────── LOGOUT ───────────────────

    public function logout(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/user/login');
    }
}
