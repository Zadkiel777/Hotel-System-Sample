<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AdminAuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // HARDENED CHECK: Must have the 'id' AND the role must be 'admin'
        if (!Session::has('id') || Session::get('role') !== 'admin') {
            return redirect()->route('main')->with('error', 'Access denied. Administrator login required.');
        }

        return $next($request);
    }
} 