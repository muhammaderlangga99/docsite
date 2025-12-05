<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function __invoke(Request $request)
    {
        $user = $request->user();
        $username = $user?->username;

        $creditDebitReady = false;
        $qrpsReady = false;

        if ($username) {
            $creditCount = DB::connection('cdcp')
                ->table('user_detail')
                ->where('username', $username)
                ->whereIn('batch_group', ['BNI_CREDIT', 'BNI_DEBIT'])
                ->count();
            $creditDebitReady = $creditCount >= 2;

            $qrpsReady = DB::connection('qrps')
                ->table('device_user_detail')
                ->where('username', $username)
                ->exists();
        }

        return view('dashboard', [
            'creditDebitReady' => $creditDebitReady,
            'qrpsReady' => $qrpsReady,
        ]);
    }
}
