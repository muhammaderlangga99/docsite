<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EricaController extends Controller
{
    public function index(Request $request)
    {
        return view('erica.index', [
            'credentials' => $request->session()->get('erica_credentials'),
            'error' => $request->session()->get('erica_error'),
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

        $clientId = 'CLID-9512DD2103143019';

        // Insert ke user_details jika belum ada
        $exists = DB::connection('bridge')
            ->table('user_details')
            ->where('username', $user->username)
            ->exists();

        if (! $exists) {
            DB::connection('bridge')->table('user_details')->insert([
                'username' => $user->username,
                'client_id' => $clientId,
                'create_at' => now(),
                'ws_token' => null,
            ]);
        }

        // Ambil api_key dan client_id dari merchant_details
        $merchant = DB::connection('bridge')
            ->table('merchant_details')
            ->where('client_id', $clientId)
            ->select('client_id', 'api_key')
            ->first();

        if (! $merchant) {
            return redirect()
                ->route('erica.index')
                ->with('erica_error', 'Merchant tidak ditemukan untuk client_id ini.');
        }

        return redirect()
            ->route('erica.index')
            ->with('erica_credentials', [
                'client_id' => $merchant->client_id,
                'api_key' => $merchant->api_key,
                'username' => $user->username,
            ]);
    }
}
