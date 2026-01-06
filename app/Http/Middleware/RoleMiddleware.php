<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!auth()->check()) {
            abort(403);
        }

        // Normalisasi role user & role yang diizinkan
        $userRole = strtolower(trim((string) auth()->user()->role));
        $allowedRoles = array_map(
            fn ($r) => strtolower(trim((string) $r)),
            $roles
        );

        if ($userRole === '' || !in_array($userRole, $allowedRoles, true)) {
            abort(403, 'ANDA TIDAK PUNYA AKSES');
        }

        return $next($request);
    }
}
