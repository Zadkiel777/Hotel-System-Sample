<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CustomerAuthMiddleware
{

public function handle(Request $request, Closure $next)
{
    // MUST have customer_id AND the role must be customer
    if (!Session::has('customer_id') || Session::get('role') !== 'customer') {
        return redirect()->route('main')->with('error', 'Access denied. Customers only.');
    }

    return $next($request);
}
}