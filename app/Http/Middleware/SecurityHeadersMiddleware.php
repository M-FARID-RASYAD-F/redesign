<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityHeadersMiddleware
{
    /**
     * Handle an incoming request and attach essential HTTP security headers.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Anti-Clickjacking: Cegah website dimuat di dalam iframe situs asing
        $response->headers->set('X-Frame-Options', 'SAMEORIGIN');

        // Cegah MIME type sniffing oleh browser
        $response->headers->set('X-Content-Type-Options', 'nosniff');

        // Lindungi privasi rujukan URL keluar
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');

        // Batasi akses sensor/fitur sensitif perangkat yang tidak dibutuhkan
        $response->headers->set('Permissions-Policy', 'camera=(), microphone=(), geolocation=()');

        // Content-Security-Policy (CSP) Defense-in-depth against XSS
        $csp = "default-src 'self'; " .
               "script-src 'self' 'unsafe-inline' 'unsafe-eval' https://cdn.jsdelivr.net; " .
               "style-src 'self' 'unsafe-inline' https://fonts.googleapis.com https://cdn.jsdelivr.net; " .
               "font-src 'self' https://fonts.gstatic.com data:; " .
               "img-src 'self' data: https: blob:; " .
               "connect-src 'self' ws: wss:; " .
               "frame-ancestors 'self'; " .
               "base-uri 'self'; " .
               "form-action 'self';";

        $response->headers->set('Content-Security-Policy', $csp);

        // HSTS (HTTP Strict Transport Security) jika koneksi menggunakan HTTPS
        if ($request->isSecure()) {
            $response->headers->set('Strict-Transport-Security', 'max-age=31536000; includeSubDomains');
        }

        return $response;
    }
}
