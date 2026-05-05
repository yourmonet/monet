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
use Laravel\Socialite\Facades\Socialite;

class GoogleAuthController extends Controller
{
    /**
     * Tentukan halaman login berdasarkan role.
     */
    private function loginRouteByRole(string $role): string
    {
        return match ($role) {
            'pengurus'  => '/pengurus/login',
            'bendahara' => '/bendahara/login',
            default     => '/user/login',
        };
    }

    /**
     * Redirect ke Google.
     * Role di-encode ke dalam `state` parameter OAuth — Google menjamin mengembalikannya
     * apa adanya tanpa modifikasi, sehingga tidak bergantung pada session.
     */
    public function redirectToGoogle(string $role): RedirectResponse
    {
        // Validasi role agar tidak ada nilai sembarangan
        $role = in_array($role, ['anggota', 'pengurus', 'bendahara']) ? $role : 'anggota';

        // Encode role ke dalam state parameter
        $state = base64_encode(json_encode(['role' => $role]));

        return Socialite::driver('google')
            ->stateless()
            ->with(['state' => $state])
            ->redirect();
    }

    /**
     * Handle callback dari Google.
     * Role dibaca dari state parameter yang dikembalikan Google (bukan dari session).
     */
    public function handleCallback(Request $request): RedirectResponse
    {
        // Baca role dari state parameter yang dikembalikan Google
        $role = 'anggota';
        $rawState = $request->get('state');
        if ($rawState) {
            $stateData = json_decode(base64_decode($rawState), true);
            if (isset($stateData['role']) && in_array($stateData['role'], ['anggota', 'pengurus', 'bendahara'])) {
                $role = $stateData['role'];
            }
        }

        $loginRoute = $this->loginRouteByRole($role);

        try {
            $googleUser = Socialite::driver('google')->stateless()->user();
        } catch (\Exception $e) {
            return redirect($loginRoute)->withErrors(['email' => 'Autentikasi Google gagal. Silakan coba lagi.']);
        }

        // 1. Cek apakah google_id sudah terdaftar
        $user = User::where('google_id', $googleUser->getId())->first();

        if ($user) {
            // Sudah punya akun Google → langsung login & arahkan ke dashboard sesuai role terdaftar
            if ($googleUser->getAvatar() && !$user->avatar) {
                $user->update(['avatar' => $googleUser->getAvatar()]);
            }
            Auth::login($user, true);
            return redirect($user->getDashboardRoute());
        }

        // 2. Cek apakah email sudah terdaftar (akun manual) → hubungkan
        $existingUser = User::where('email', $googleUser->getEmail())->first();

        if ($existingUser) {
            $existingUser->update([
                'google_id' => $googleUser->getId(),
                'avatar'    => $existingUser->avatar ?: $googleUser->getAvatar()
            ]);
            Auth::login($existingUser, true);
            return redirect($existingUser->getDashboardRoute());
        }

        // 3. User baru → simpan data ke session, minta lengkapi profil
        session([
            'google_user' => [
                'google_id' => $googleUser->getId(),
                'name'      => $googleUser->getName(),
                'email'     => $googleUser->getEmail(),
                'avatar'    => $googleUser->getAvatar(),
                'role'      => $role,
            ],
        ]);

        return redirect()->route('auth.google.complete');
    }

    /**
     * Tampilkan form "Lengkapi Profil" untuk user baru via Google.
     */
    public function showCompleteProfile(): View|RedirectResponse
    {
        if (!session('google_user')) {
            return redirect('/user/login');
        }

        return view('auth.google-complete-profile', [
            'googleUser' => session('google_user'),
        ]);
    }

    /**
     * Simpan profil user baru yang mendaftar via Google.
     */
    public function completeProfile(Request $request): RedirectResponse
    {
        $googleUserData = session('google_user');

        if (!$googleUserData) {
            return redirect('/user/login')->withErrors(['email' => 'Sesi Google tidak valid. Silakan ulangi proses login.']);
        }

        $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $role = $googleUserData['role'] ?? 'anggota';

        User::create([
            'name'      => $request->name,
            'email'     => $googleUserData['email'],
            'google_id' => $googleUserData['google_id'],
            'avatar'    => $googleUserData['avatar'] ?? null,
            'password'  => Hash::make($request->password),
            'role'      => $role,
        ]);

        session()->forget('google_user');

        $loginRoute = $this->loginRouteByRole($role);

        return redirect($loginRoute)->with('success', 'Akun berhasil dibuat. Silakan login.');
    }
}
