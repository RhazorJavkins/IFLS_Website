<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Opsional: batasi akses panel admin ke IP tertentu (mis. IP kantor).
 * Isi ADMIN_IP_ALLOWLIST di .env, dipisah koma. Kosong = tidak dibatasi.
 */
class AdminIpAllowlist
{
    public function handle(Request $request, Closure $next): Response
    {
        $raw = trim((string) config('security.admin_ip_allowlist'));

        if ($raw !== '') {
            $allowlist = array_filter(array_map('trim', explode(',', $raw)));

            if (! in_array($request->ip(), $allowlist, true)) {
                abort(403, 'Akses admin tidak diizinkan dari IP ini.');
            }
        }

        return $next($request);
    }
}
