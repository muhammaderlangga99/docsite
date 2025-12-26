<?php

namespace App\Http\Controllers;

use App\Services\EricaCredentialService;
use Illuminate\Http\Request;
use Throwable;

class EricaController extends Controller
{
    public function index(Request $request, EricaCredentialService $service)
    {
        $user = $request->user();
        $credentials = null;
        $existing = null;

        if ($user?->username) {
            $result = $service->resolveCredentials($user->username);
            $credentials = $result['credentials'];
            $existing = $result['merchant'];
        }

        return view('erica.index', [
            'credentials' => $credentials,
            'error' => $request->session()->get('erica_error'),
            'existing' => $existing,
        ]);
    }

    public function generate(Request $request, EricaCredentialService $service)
    {
        $user = $request->user();

        if (! $user?->username) {
            return redirect()
                ->route('erica.index')
                ->with('erica_error', 'Username tidak ditemukan. Pastikan akun memiliki username.');
        }

        // Merchant statis 125 di DB master.
        $existing = $service->getMerchantDetails();

        if (! $existing) {
            return redirect()
                ->route('erica.index')
                ->with('erica_error', 'Merchant 125 belum tersedia di bridge.merchant_details.');
        }

        try {
            // Pastikan user_details ada (gunakan client_id merchant 125).
            $service->ensureUserDetail($user->username, $existing->client_id);
        } catch (Throwable $e) {
            report($e);

            return redirect()
                ->route('erica.index')
                ->with('erica_error', 'Gagal membuat kredensial. Silakan coba lagi.');
        }

        return redirect()
            ->route('erica.index');
    }
}
