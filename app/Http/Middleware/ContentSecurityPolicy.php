<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ContentSecurityPolicy
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Menambahkan header CSP
        $response->headers->set('Content-Security-Policy', 
            "default-src 'self'; 
             script-src 'self' https://apis.google.com; 
             style-src 'self' 'unsafe-inline'; 
             img-src 'self' data: https:;
             font-src 'self' https: data:; 
             frame-src 'self';");

        return $response;
    }
}
