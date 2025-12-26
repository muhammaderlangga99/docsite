<?php

namespace App\Http\Controllers;

use App\Services\MiniAtmCredentialService;
use Illuminate\Http\Request;
use Throwable;

class MiniAtmCredentialController extends Controller
{
    public function index(Request $request, MiniAtmCredentialService $service)
    {
        $user = $request->user();
        $credentials = null;

        if ($user?->username) {
            $credentials = $service->getLatestCredentialsForUser($user->username);
        }

        return view('mini-atm.index', [
            'credentials' => $credentials,
            'privateKey' => $request->session()->pull('mini_atm_private_key'),
            'warning' => $request->session()->pull('mini_atm_warning'),
            'message' => $request->session()->pull('mini_atm_success'),
            'error' => $request->session()->pull('mini_atm_error'),
        ]);
    }

    public function generate(Request $request, MiniAtmCredentialService $service)
    {
        $user = $request->user();

        if (! $user?->username) {
            return redirect()
                ->route('mini-atm.index')
                ->with('mini_atm_error', 'Username tidak ditemukan. Pastikan akun memiliki username.');
        }

        try {
            $result = $service->generateCredentials($user->username);
        } catch (Throwable $e) {
            report($e);

            return redirect()
                ->route('mini-atm.index')
                ->with('mini_atm_error', 'Gagal membuat credentials. Silakan coba lagi.');
        }

        return redirect()
            ->route('mini-atm.index')
            ->with('mini_atm_private_key', $result['private_key'])
            ->with('mini_atm_warning', $result['warning'])
            ->with('mini_atm_success', 'Credentials berhasil digenerate.')
            ->with('mini_atm_partner_id', $result['partner_id']);
    }

    public function regenerate(Request $request, MiniAtmCredentialService $service)
    {
        $user = $request->user();
        $partnerId = (int) $request->input('partner_id');

        if (! $user?->username || ! $partnerId) {
            return redirect()
                ->route('mini-atm.index')
                ->with('mini_atm_error', 'Partner tidak ditemukan untuk pengguna ini.');
        }

        $owned = $service->isPartnerOwnedByUser($partnerId, $user->username);

        if (! $owned) {
            return redirect()
                ->route('mini-atm.index')
                ->with('mini_atm_error', 'Partner tidak ditemukan untuk pengguna ini.');
        }

        try {
            $result = $service->regenerateKey($partnerId);
        } catch (Throwable $e) {
            report($e);

            return redirect()
                ->route('mini-atm.index')
                ->with('mini_atm_error', 'Gagal regenerate key. Silakan coba lagi.');
        }

        return redirect()
            ->route('mini-atm.index')
            ->with('mini_atm_private_key', $result['private_key'])
            ->with('mini_atm_warning', $result['warning'])
            ->with('mini_atm_success', 'Key berhasil diregenerate. Pastikan simpan private key baru.')
            ->with('mini_atm_partner_id', $partnerId);
    }
}
