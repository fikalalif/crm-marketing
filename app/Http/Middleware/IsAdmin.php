<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        // Jika yang login bukan admin, tendang ke halaman 403 (Unauthorized)
        if (auth()->check() && auth()->user()->role !== 'admin') {
            abort(403, 'Akses ditolak. Anda bukan Administrator.');
        }

        return $next($request);
    }
}
