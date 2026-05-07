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

class BendaharaAuthController extends Controller
{
    // ─────────────────── LOGIN ───────────────────

    public function showLogin(): View|RedirectResponse
    {
        if (Auth::check() && Auth::user()->role === 'bendahara') {
            return redirect('/bendahara/dashboard');
        }
        return view('bendahara.login');
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

            if ($user->role !== 'bendahara') {
                Auth::logout();
                return back()->withErrors([
                    'email' => 'Akun ini bukan akun bendahara. Silakan gunakan halaman login yang sesuai.',
                ])->withInput($request->except('password'));
            }

            $request->session()->regenerate();
            return redirect('/bendahara/dashboard');
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->withInput($request->except('password'));
    }

    // ─────────────────── REGISTER ───────────────────

    public function showRegister(): View|RedirectResponse
    {
        if (Auth::check() && Auth::user()->role === 'bendahara') {
            return redirect('/bendahara/dashboard');
        }
        return view('bendahara.register');
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
            'role'     => 'bendahara',
        ]);

        return redirect('/bendahara/login')->with('success', 'Akun berhasil dibuat. Silakan login.');
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

        // Ambil 10 data terbaru agar punya cukup sampel untuk digabungkan
        $kasMasuk = \App\Models\KasMasuk::latest('created_at')->take(10)->get()->map(function ($item) {
            $item->type = 'masuk';
            $item->nominal_transaksi = $item->jumlah;
            return $item;
        });

        $kasKeluar = \App\Models\KasKeluar::latest('created_at')->take(10)->get()->map(function ($item) {
            $item->type = 'keluar';
            $item->nominal_transaksi = $item->nominal;
            return $item;
        });

        // Gabungkan, lalu sortir berdasarkan waktu input yang paling akurat (created_at), baru ambil 5 teratas
        $transaksiTerbaru = $kasMasuk->concat($kasKeluar)->sortByDesc('created_at')->take(5);

        return view('bendahara.dashboard', compact('pemasukanBulanIni', 'pengeluaranBulanIni', 'totalSaldo', 'transaksiTerbaru'));
    }

    // ─────────────────── LOGOUT ───────────────────

    public function logout(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/bendahara/login');
    }
}
