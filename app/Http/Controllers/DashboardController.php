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
        $miniAtmReady = false;
        $creditDebitTid = null;
        $miniAtmTid = null;
        $merchantMid = null;
        $bnplReady = false;

        if ($username) {
            $creditCount = DB::connection('cdcp')
                ->table('user_detail')
                ->where('username', $username)
                ->whereIn('batch_group', ['BNI_CREDIT', 'BNI_DEBIT'])
                ->count();
            $creditDebitReady = $creditCount >= 2;

            if ($creditDebitReady) {
                $creditDebitTid = DB::connection('cdcp')
                    ->table('user_detail')
                    ->where('username', $username)
                    ->orderByDesc('id')
                    ->value('tid');
            }

            $qrpsReady = DB::connection('qrps')
                ->table('device_user_detail')
                ->where('username', $username)
                ->exists();

            $miniAtmReady = DB::connection('mini_atm')
                ->table('user_detail')
                ->where('username', $username)
                ->exists();

            if ($miniAtmReady) {
                $miniAtmTid = DB::connection('mini_atm')
                    ->table('user_detail')
                    ->where('username', $username)
                    ->orderByDesc('id')
                    ->value('tid');
            }

            $merchantMid = DB::connection('cdcp')
                ->table('merchant_mid')
                ->where('merchant_id', 125)
                ->orderByDesc('id')
                ->value('mid');

            $bnplReady = DB::connection('bnpl')
                ->table('device_user_detail')
                ->where('username', $username)
                ->exists();
        }

        return view('dashboard', [
            'creditDebitReady' => $creditDebitReady,
            'qrpsReady' => $qrpsReady,
            'miniAtmReady' => $miniAtmReady,
            'creditDebitTid' => $creditDebitTid,
            'miniAtmTid' => $miniAtmTid,
            'merchantMid' => $merchantMid,
            'bnplReady' => $bnplReady,
        ]);
    }
}
