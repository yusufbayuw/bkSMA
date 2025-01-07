<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RemoveTimestampHeaders
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Hapus header yang mengandung timestamp
        $response->headers->remove('Date');
        $response->headers->remove('Last-Modified');
        $response->headers->remove('ETag');

        return $response;
    }
}
