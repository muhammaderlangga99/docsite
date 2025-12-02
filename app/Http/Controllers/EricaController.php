<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Throwable;

class EricaController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $existing = null;
        $credentials = null;

        if ($user?->username) {
            $existing = DB::connection('bridge')
                ->table('merchant_details')
                ->where('merchant_id', 125)
                ->select('id', 'client_id', 'api_key')
                ->first();

            $userDetail = DB::connection('bridge')
                ->table('user_details')
                ->where('username', $user->username)
                ->select('client_id')
                ->first();

            if ($existing && $userDetail && $userDetail->client_id === $existing->client_id) {
                $credentials = [
                    'username' => $user->username,
                    'client_id' => $existing->client_id,
                    'api_key' => $existing->api_key,
                ];
            }
        }

        return view('erica.index', [
            'credentials' => $credentials,
            'error' => $request->session()->get('erica_error'),
            'existing' => $existing,
        ]);
    }

    public function generate(Request $request)
    {
        $user = $request->user();

        if (! $user?->username) {
            return redirect()
                ->route('erica.index')
                ->with('erica_error', 'Username tidak ditemukan. Pastikan akun memiliki username.');
        }

        // Merchant statis 125 di DB master
        $merchantId = 125;

        // Ambil merchant_details untuk merchant 125
        $existing = DB::connection('bridge')
            ->table('merchant_details')
            ->where('merchant_id', $merchantId)
            ->first();

        if (! $existing) {
            return redirect()
                ->route('erica.index')
                ->with('erica_error', 'Merchant 125 belum tersedia di bridge.merchant_details.');
        }

        $clientId = $existing->client_id;

        try {
            DB::connection('bridge')->beginTransaction();

            // Pastikan user_details ada (gunakan client_id merchant 125)
            $userDetailExists = DB::connection('bridge')
                ->table('user_details')
                ->where('username', $user->username)
                ->exists();

            if (! $userDetailExists) {
                DB::connection('bridge')->table('user_details')->insert([
                    'username' => $user->username,
                    'client_id' => $clientId,
                    'create_at' => now(),
                    'ws_token' => null,
                ]);
            } else {
                // Pastikan client_id sinkron
                DB::connection('bridge')
                    ->table('user_details')
                    ->where('username', $user->username)
                    ->update([
                        'client_id' => $clientId,
                    ]);
            }

            DB::connection('bridge')->commit();
        } catch (Throwable $e) {
            DB::connection('bridge')->rollBack();
            report($e);

            return redirect()
                ->route('erica.index')
                ->with('erica_error', 'Gagal membuat kredensial. Silakan coba lagi.');
        }

        return redirect()
            ->route('erica.index');
    }

    private function generateClientId(): string
    {
        return 'CLID-' . str_pad((string) random_int(0, 9999999999999999), 16, '0', STR_PAD_LEFT);
    }

    private function generateApiKey(): string
    {
        return strtoupper(Str::random(100));
    }
}
