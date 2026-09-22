<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

/**
 * Batasi akses panel berdasarkan kolom role user.
 * Pemakaian di panel: ->authMiddleware([Authenticate::class, EnsureRole::class . ':admin,teacher'])
 *
 * Selain 403, session di-flush: mencegah "session nyangkut" setelah ganti akun,
 * sehingga request berikutnya (sebagai tamu) dialihkan ke login dengan benar.
 */
class EnsureRole
{
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $user = $request->user();

        if (! $user || ! in_array($user->role, $roles, true)) {
            if ($user) {
                Auth::guard('web')->logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
            }

            abort(403, 'Akun Anda tidak memiliki akses ke portal ini.');
        }

        return $next($request);
    }
}
