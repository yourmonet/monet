<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Mail\VerifyEmailCode;

class OtpVerificationController extends Controller
{
    public function notice()
    {
        if (!session()->has('pending_registration')) {
            return redirect('/');
        }
        return view('auth.otp-verify');
    }

    public function verify(Request $request)
    {
        $request->validate([
            'code' => ['required', 'string', 'size:6'],
        ]);

        $pending = session('pending_registration');

        if (!$pending) {
            return redirect('/')->withErrors(['email' => 'Sesi pendaftaran tidak ditemukan. Silakan daftar kembali.']);
        }

        if ($pending['verification_code'] !== $request->code) {
            return back()->withErrors(['code' => 'Kode verifikasi salah.']);
        }

        if (now()->greaterThan($pending['verification_code_expires_at'])) {
            return back()->withErrors(['code' => 'Kode verifikasi sudah kadaluarsa. Silakan kirim ulang kode.']);
        }

        // Create the user in database
        $user = User::create([
            'name' => $pending['name'],
            'email' => $pending['email'],
            'password' => $pending['password'],
            'role' => $pending['role'],
            'email_verified_at' => now(),
            'verification_code' => null,
            'verification_code_expires_at' => null,
        ]);

        session()->forget('pending_registration');

        $loginRoute = match ($user->role) {
            'pengurus' => route('pengurus.login'),
            'bendahara' => route('bendahara.login'),
            default => route('user.login'),
        };

        return redirect($loginRoute)->with('success', 'Email berhasil diverifikasi! Silakan login.');
    }

    public function resend(Request $request)
    {
        $pending = session('pending_registration');

        if (!$pending) {
            return redirect('/');
        }

        $code = sprintf("%06d", mt_rand(1, 999999));
        
        $pending['verification_code'] = $code;
        $pending['verification_code_expires_at'] = now()->addMinutes(15);
        
        session()->put('pending_registration', $pending);

        Mail::to($pending['email'])->send(new VerifyEmailCode($code));

        return back()->with('status', 'Kode verifikasi baru telah dikirim ke email Anda.');
    }

    private function getDashboardRoute($role)
    {
        if ($role === 'anggota') return route('user.dashboard');
        if ($role === 'pengurus') return route('pengurus.dashboard');
        if ($role === 'bendahara') return route('bendahara.dashboard');
        return '/';
    }
}
