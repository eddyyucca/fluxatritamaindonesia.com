<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ForcePasswordChange
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (\Illuminate\Support\Facades\Auth::check() && \Illuminate\Support\Facades\Auth::user()->must_change_password) {
            // Biarkan user mengakses route logout atau form edit profil (tempat ubah password)
            if (!$request->routeIs('profile.edit', 'profile.update', 'profile.password', 'logout')) {
                return redirect()->route('profile.edit')
                    ->with('warning', 'Anda wajib memperbarui password Anda sebelum melanjutkan menggunakan sistem.');
            }
        }
        return $next($request);
    }
}
