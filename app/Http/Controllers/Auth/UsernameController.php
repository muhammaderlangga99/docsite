<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Throwable;

class UsernameController extends Controller
{
    public function create()
    {
        return view('auth.set-username');
    }

    public function store(Request $request): RedirectResponse
    {
        $user = $request->user();

        if (! $user) {
            abort(403);
        }

        $validated = $request->validate([
            'username' => ['required', 'string', 'max:50', 'regex:/^[A-Za-z0-9_]+$/', 'unique:users,username'],
        ]);

        try {
            $user->update([
                'username' => $validated['username'],
            ]);

            $user->ensureMasterMobileUser();
        } catch (Throwable $e) {
            report($e);

            throw ValidationException::withMessages([
                'username' => 'Gagal menyimpan username, silakan coba lagi.',
            ]);
        }

        return redirect()->route('dashboard');
    }
}
