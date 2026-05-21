<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Mail\ResetPasswordCode;
use Illuminate\Validation\Rules;

class OtpPasswordResetController extends Controller
{
    public function request()
    {
        return view('auth.otp-forgot-password');
    }

    public function sendCode(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email', 'exists:users,email'],
        ]);

        $code = sprintf("%06d", mt_rand(1, 999999));

        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $request->email],
            ['token' => Hash::make($code), 'created_at' => now()]
        );

        Mail::to($request->email)->send(new ResetPasswordCode($code));

        session(['reset_email' => $request->email]);

        return redirect()->route('password.verify_otp.form')->with('status', 'Kode reset telah dikirim ke email Anda.');
    }

    public function showVerifyOtpForm()
    {
        if (!session('reset_email')) {
            return redirect()->route('password.request');
        }
        return view('auth.otp-verify-reset');
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'code' => ['required', 'string', 'size:6'],
        ]);

        $email = session('reset_email');
        if (!$email) {
            return redirect()->route('password.request');
        }

        $record = DB::table('password_reset_tokens')->where('email', $email)->first();

        if (!$record || !Hash::check($request->code, $record->token)) {
            return back()->withErrors(['code' => 'Kode reset salah atau sudah tidak berlaku.']);
        }

        if (now()->subMinutes(15)->greaterThan($record->created_at)) {
            DB::table('password_reset_tokens')->where('email', $email)->delete();
            return back()->withErrors(['code' => 'Kode reset sudah kadaluarsa. Silakan minta kode baru.']);
        }

        session(['reset_otp_verified' => true]);

        return redirect()->route('password.reset.form');
    }

    public function showResetForm()
    {
        if (!session('reset_email') || !session('reset_otp_verified')) {
            return redirect()->route('password.request');
        }
        return view('auth.otp-reset-password');
    }

    public function reset(Request $request)
    {
        $request->validate([
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $email = session('reset_email');
        if (!$email || !session('reset_otp_verified')) {
            return redirect()->route('password.request');
        }

        $user = User::where('email', $email)->first();
        if (!$user) {
            return redirect()->route('password.request');
        }

        $user->update([
            'password' => Hash::make($request->password)
        ]);

        DB::table('password_reset_tokens')->where('email', $email)->delete();
        session()->forget(['reset_email', 'reset_otp_verified']);

        if ($user->role === 'anggota') return redirect('/user/login')->with('success', 'Password berhasil direset. Silakan login.');
        if ($user->role === 'pengurus') return redirect('/pengurus/login')->with('success', 'Password berhasil direset. Silakan login.');
        if ($user->role === 'bendahara') return redirect('/bendahara/login')->with('success', 'Password berhasil direset. Silakan login.');
        
        return redirect('/user/login')->with('success', 'Password berhasil direset.');
    }
}
