<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityHeaders
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        $response->headers->set('X-Content-Type-Options', 'nosniff');
        $response->headers->set('X-Frame-Options', 'SAMEORIGIN');
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');
        $response->headers->set('Permissions-Policy', 'camera=(), microphone=(), geolocation=(), payment=()');

        // HSTS hanya saat produksi + HTTPS (lokal HTTP jangan, biar bisa diakses)
        if (config('app.env') === 'production' && $request->secure()) {
            $response->headers->set('Strict-Transport-Security', 'max-age=31536000; includeSubDomains');
        }

        // CSP — default Report-Only dulu, set SECURITY_CSP_ENFORCE=true di .env setelah log bersih
        $csp = config('security.csp');
        if ($csp) {
            $header = config('security.csp_enforce')
                ? 'Content-Security-Policy'
                : 'Content-Security-Policy-Report-Only';
            $response->headers->set($header, $csp);
        }

        return $response;
    }
}
