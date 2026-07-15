<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsNotAdmin
{
    /**
     * Handle an incoming request.
     * Blocks admin users from accessing regular user-only features.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check() && auth()->user()->is_admin) {
            return redirect()->route('admin.dashboard')
                ->with('error', 'Admin tidak bisa mengakses fitur ini.');
        }

        return $next($request);
    }
}
