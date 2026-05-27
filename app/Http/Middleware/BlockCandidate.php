<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class BlockCandidate
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check() && auth()->user()->role === 'candidate') {
            return redirect()->route('career.dashboard');
        }
        return $next($request);
    }
}
