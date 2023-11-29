<?php

namespace App\Http\Middleware;

use Closure;

class CheckUserStatus
{
    // app/Http/Middleware/CheckUserStatus.php

    public function handle($request, Closure $next, $allowedStatus)
    {
        $user = auth()->user();
        $statusAliases = [
            'admin' => 1,
            'guru' => 2,
            'siswa' => 3,
        ];

        if (auth()->check() && array_key_exists($allowedStatus, $statusAliases) && $user->level_id === $statusAliases[$allowedStatus]) {
            return $next($request);
        }

        abort(404);

    }
}
