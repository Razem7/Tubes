<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsNotAdmin
{
    /**
     * Blokir super_admin dari fitur user biasa.
     * Merchant dan user biasa boleh lewat.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check() && auth()->user()->isSuperAdmin()) {
            return redirect()->route('admin.dashboard')
                ->with('error', 'Super Admin tidak bisa mengakses fitur ini.');
        }

        return $next($request);
    }
}
