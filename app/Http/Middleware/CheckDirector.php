<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckDirector
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check() && !auth()->user()->isDirector()) {
            abort(403, 'Akses ditolak. Halaman ini khusus untuk Director/HR.');
        }
        return $next($request);
    }
}
