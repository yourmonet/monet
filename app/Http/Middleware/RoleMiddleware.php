<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Mapping dari nama role ke URL prefix.
     */
    private array $roleToPrefix = [
        'anggota'   => 'user',
        'pengurus'  => 'pengurus',
        'bendahara' => 'bendahara',
    ];

    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        // Belum login → redirect ke login page role yang sesuai
        if (!Auth::check()) {
            $prefix = $this->roleToPrefix[$role] ?? 'user';
            return redirect("/{$prefix}/login");
        }

        $user = Auth::user();

        // Sudah login tapi role salah → redirect ke dashboard sesuai role mereka
        if ($user->role !== $role) {
            $userPrefix = $this->roleToPrefix[$user->role] ?? 'user';
            return redirect("/{$userPrefix}/dashboard")
                ->with('error', 'Anda tidak memiliki akses ke halaman tersebut.');
        }

        return $next($request);
    }
}
