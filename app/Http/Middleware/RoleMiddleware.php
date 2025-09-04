<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  ...$roles
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        // Pastikan user login
        if (!Auth::check()) {
            return redirect('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $user = Auth::user();

        // Normalisasi role (biar case-insensitive)
        $roles = array_map('strtolower', $roles);
        $userRole = strtolower($user->role);

        if (!in_array($userRole, $roles)) {
            // Jika role tidak sesuai
            return redirect('/')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
            // atau kalau mau lebih strict:
            // abort(403, 'Forbidden: Role tidak sesuai.');
        }

        return $next($request);
    }
}
