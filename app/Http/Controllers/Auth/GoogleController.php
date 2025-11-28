<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

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
            $payload = [
                'google_id' => $googleUser->getId(),
                'name' => $googleUser->getName() ?: $user->name,
                'avatar' => $googleUser->getAvatar() ?: $user->avatar,
            ];

            if (empty($user->username)) {
                $payload['username'] = User::generateUniqueUsername($googleUser->getName() ?: $googleUser->getEmail());
            }

            $user->update($payload);
        } else {
            $user = User::create([
                'name' => $googleUser->getName() ?: $googleUser->getEmail(),
                'email' => $googleUser->getEmail(),
                'google_id' => $googleUser->getId(),
                'avatar' => $googleUser->getAvatar(),
                'username' => User::generateUniqueUsername($googleUser->getName() ?: $googleUser->getEmail()),
                // Password random biar field tidak null, tapi login tetap via Google.
                'password' => Hash::make(Str::random(32)),
            ]);
        }

        // Sync external records if missing (only master mobile)
        $user->ensureMasterMobileUser();

        Auth::login($user, remember: true);

        return redirect('/dashboard');
    }
}
