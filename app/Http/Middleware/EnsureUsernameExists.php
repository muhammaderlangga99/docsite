<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUsernameExists
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (! $user) {
            return $next($request);
        }

        if (! empty($user->username)) {
            return $next($request);
        }

        $allowed = [
            'username.store',
            'username.create',
            'logout',
        ];

        if (in_array($request->route()?->getName(), $allowed, true)) {
            return $next($request);
        }

        // Paksa kembali ke dashboard agar modal username muncul.
        return redirect()->route('dashboard');
    }
}
