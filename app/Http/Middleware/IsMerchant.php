<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsMerchant
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! auth()->check() || ! auth()->user()->isMerchant()) {
            abort(403, 'Akses ditolak. Hanya Merchant.');
        }

        return $next($request);
    }
}
