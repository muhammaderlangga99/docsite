<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class EnsureProfileComplete
{
    /**
     * Pastikan user punya username & device_id, dan device terdaftar di DB master.
     */
    public function handle(Request $request, Closure $next): Response|RedirectResponse
    {
        $user = $request->user();

        if (! $user) {
            return redirect()->route('login');
        }

        $missingProfile = empty($user->username) || empty($user->device_id);
        $hasDevice = false;

        if (! $missingProfile) {
            $hasDevice = DB::connection('master')
                ->table('device')
                ->where('device_id', $user->device_id)
                ->exists();
        }

        if ($missingProfile || ! $hasDevice) {
            return redirect()->route('username.create')->withErrors([
                'username' => 'Lengkapi username dan device number terlebih dahulu.',
            ]);
        }

        return $next($request);
    }
}
