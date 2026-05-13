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
use Illuminate\Support\Facades\Mail;
use App\Mail\VerifyEmailCode;

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

        $code = sprintf("%06d", mt_rand(1, 999999));

        session()->put('pending_registration', [
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'anggota',
            'verification_code' => $code,
            'verification_code_expires_at' => now()->addMinutes(15),
        ]);

        Mail::to($request->email)->send(new VerifyEmailCode($code));

        return redirect()->route('verification.notice');
    }

    // ─────────────────── DASHBOARD ───────────────────

    public function dashboard(): View
    {
        $currentMonth = \Carbon\Carbon::now()->month;
        $currentYear = \Carbon\Carbon::now()->year;

        $pemasukanBulanIni = \App\Models\KasMasuk::whereMonth('tanggal', $currentMonth)
            ->whereYear('tanggal', $currentYear)
            ->sum('jumlah');

        $pengeluaranBulanIni = \App\Models\KasKeluar::whereMonth('tanggal', $currentMonth)
            ->whereYear('tanggal', $currentYear)
            ->sum('nominal');

        $totalPemasukan = \App\Models\KasMasuk::sum('jumlah');
        $totalPengeluaran = \App\Models\KasKeluar::sum('nominal');
        $totalSaldo = $totalPemasukan - $totalPengeluaran;

        $kasMasuk = \App\Models\KasMasuk::latest('tanggal')->take(5)->get()->map(function ($item) {
            $item->type = 'masuk';
            $item->nominal_transaksi = $item->jumlah;
            return $item;
        });

        $kasKeluar = \App\Models\KasKeluar::latest('tanggal')->take(5)->get()->map(function ($item) {
            $item->type = 'keluar';
            $item->nominal_transaksi = $item->nominal;
            return $item;
        });

        $transaksiTerbaru = $kasMasuk->concat($kasKeluar)->sortByDesc('tanggal')->take(5);

        return view('user.dashboard', compact('pemasukanBulanIni', 'pengeluaranBulanIni', 'totalSaldo', 'transaksiTerbaru'));
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
