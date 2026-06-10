<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class UniversalAuthController extends Controller
{
    public function showLogin(): View|RedirectResponse
    {
        if (Auth::check()) {
            return redirect(Auth::user()->getDashboardRoute());
        }
        return view('auth.login');
    }

    public function login(Request $request): RedirectResponse
    {
        $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended(Auth::user()->getDashboardRoute());
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->withInput($request->except('password'));
    }

    // Optional: a universal logout just in case, though they currently have role-specific ones.
    // It's better to keep role-specific ones for now as they might have specific logic,
    // but a universal logout is also easy to implement.
    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
