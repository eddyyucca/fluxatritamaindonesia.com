<?php

namespace Modules\Setting\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class DirectorOnlyMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check() && auth()->user()->isDirector()) {
            return $next($request);
        }

        abort(403, 'Akses Ditolak. Hanya Direktur yang diizinkan mengakses halaman ini.');
    }
}
