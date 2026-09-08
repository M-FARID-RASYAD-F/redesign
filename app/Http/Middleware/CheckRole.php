<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  ...$roles
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $user = $request->user();

        if (! $user) {
            return redirect()->route('login');
        }

        if (! $user->is_active) {
            abort(403, 'Akun Anda dinonaktifkan. Silakan hubungi Administrator.');
        }

        // super_admin memiliki akses penuh ke seluruh rute admin
        if ($user->isSuperAdmin() || in_array($user->role, $roles)) {
            return $next($request);
        }

        abort(403, 'Akses ditolak: Anda tidak memiliki izin untuk mengakses modul ini.');
    }
}
