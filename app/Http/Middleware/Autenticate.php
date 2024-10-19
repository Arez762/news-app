<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Authenticate
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        if (Auth::guard()->guest()) {
            return redirect()->route('login'); // Sesuaikan rute login jika perlu
        }

        return $next($request);
    }
}
