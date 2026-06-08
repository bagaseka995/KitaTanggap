<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Redirect pengguna yang sudah login ke dashboard sesuai perannya.
     * Mencegah akses ke halaman login/register oleh pengguna yang sudah masuk.
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                $user = Auth::guard($guard)->user();

                $redirectTo = match ($user->peran) {
                    'admin'   => route('admin.dashboard'),
                    'relawan' => route('relawan.dashboard'),
                    'donatur' => route('donatur.dashboard'),
                    default   => '/',
                };

                return redirect($redirectTo);
            }
        }

        return $next($request);
    }
}
