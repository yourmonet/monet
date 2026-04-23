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

class PengurusAuthController extends Controller
{
    // ─────────────────── LOGIN ───────────────────

    public function showLogin(): View|RedirectResponse
    {
        if (Auth::check() && Auth::user()->role === 'pengurus') {
            return redirect('/pengurus/dashboard');
        }
        return view('pengurus.login');
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

            if ($user->role !== 'pengurus') {
                Auth::logout();
                return back()->withErrors([
                    'email' => 'Akun ini bukan akun pengurus. Silakan gunakan halaman login yang sesuai.',
                ])->withInput($request->except('password'));
            }

            $request->session()->regenerate();
            return redirect('/pengurus/dashboard');
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->withInput($request->except('password'));
    }

    // ─────────────────── REGISTER ───────────────────

    public function showRegister(): View|RedirectResponse
    {
        if (Auth::check() && Auth::user()->role === 'pengurus') {
            return redirect('/pengurus/dashboard');
        }
        return view('pengurus.register');
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
            'role'     => 'pengurus',
        ]);

        return redirect('/pengurus/login')->with('success', 'Akun berhasil dibuat. Silakan login.');
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

        return view('pengurus.dashboard', compact('pemasukanBulanIni', 'pengeluaranBulanIni', 'totalSaldo', 'transaksiTerbaru'));
    }

    // ─────────────────── LOGOUT ───────────────────

    public function logout(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/pengurus/login');
    }
}
