<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class ValidateRedirectBody
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        if ($response->isRedirection() && strlen($response->getContent()) > 0) {
            // Log atau tangani jika body tidak kosong
            Log::warning('Redirect response contains body content', [
                'url' => $request->url(),
                'status' => $response->getStatusCode(),
            ]);

            // Hapus body content
            $response->setContent('');
        }

        return $response;
    }
}
