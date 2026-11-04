<?php

namespace App\Http\Middleware;

// ==================================================
// BAGIAN 1: IMPORT DAN DEPENDENSI
// ==================================================

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

// ==================================================
// BAGIAN 2: MIDDLEWARE ANTI-CACHE
// ==================================================

class PreventBackHistory
{
    // ==================================================
    // BAGIAN 3: PENGATURAN RESPONSE
    // ==================================================

    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        $response->headers->set(
            'Cache-Control',
            'no-store, no-cache, must-revalidate, private'
        );

        $response->headers->set('Pragma', 'no-cache');
        $response->headers->set('Expires', '0');

        return $response;
    }
}
