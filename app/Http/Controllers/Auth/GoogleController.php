<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use Throwable;

class GoogleController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback()
    {
        $googleUser = Socialite::driver('google')->stateless()->user();

        // Temukan user berdasarkan google_id atau email yang sama.
        $user = User::where('google_id', $googleUser->getId())
            ->orWhere('email', $googleUser->getEmail())
            ->first();

        if ($user) {
            $user->update([
                'google_id' => $googleUser->getId(),
                'name' => $googleUser->getName() ?: $user->name,
                'avatar' => $googleUser->getAvatar() ?: $user->avatar,
            ]);
        } else {
            $user = User::create([
                'name' => $googleUser->getName() ?: $googleUser->getEmail(),
                'email' => $googleUser->getEmail(),
                'google_id' => $googleUser->getId(),
                'avatar' => $googleUser->getAvatar(),
                // Password random biar field tidak null, tapi login tetap via Google.
                'password' => Hash::make(Str::random(32)),
                'email_verified_at' => now(),
            ]);
        }

        // Tandai email verified untuk akun Google kalau belum.
        if (! $user->hasVerifiedEmail()) {
            $user->forceFill(['email_verified_at' => now()])->save();
        }

        Auth::login($user, remember: true);

        if (empty($user->username)) {
            return redirect()->route('username.create');
        }

        try {
            $user->ensureMasterMobileUser();
        } catch (Throwable $e) {
            report($e);

            return redirect()->route('login')->withErrors([
                'email' => 'Login Google gagal karena sinkronisasi user. Silakan coba lagi.',
            ]);
        }

        return redirect('/dashboard');
    }
}
