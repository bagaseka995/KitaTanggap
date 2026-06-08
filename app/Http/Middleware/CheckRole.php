<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Cek apakah pengguna yang sudah login memiliki peran yang diizinkan.
     * Usage: Route::middleware('role:admin') atau Route::middleware('role:admin,relawan')
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        if (!$request->user()) {
            return $request->wantsJson()
                ? response()->json(['message' => 'Unauthenticated.'], 401)
                : redirect()->route('login');
        }

        if (!in_array($request->user()->peran, $roles)) {
            if ($request->wantsJson()) {
                return response()->json([
                    'message' => 'Anda tidak memiliki akses ke halaman ini.',
                ], 403);
            }

            abort(403, 'Akses ditolak. Halaman ini hanya untuk: ' . implode(', ', $roles) . '.');
        }

        return $next($request);
    }
}
