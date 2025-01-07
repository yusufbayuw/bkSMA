<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ClickjackingProtection
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Menambahkan header X-Frame-Options
        $response->headers->set('X-Frame-Options', 'DENY');

        // Atau menambahkan Content-Security-Policy dengan frame-ancestors
        $response->headers->set('Content-Security-Policy', "frame-ancestors 'none';");

        return $response;
    }
}
