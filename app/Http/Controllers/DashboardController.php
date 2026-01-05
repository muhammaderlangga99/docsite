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
        $bnplReady = false;
        $creditDebitTid = null;
        $miniAtmTid = null;
        $merchantMid = null;

        if (!$username) {
            return view('dashboard', compact(
                'creditDebitReady','qrpsReady','miniAtmReady',
                'creditDebitTid','miniAtmTid','merchantMid','bnplReady'
            ));
        }

        try {
            // === CDCP ===
            $cdcpUsers = DB::connection('cdcp')
                ->table('user_detail')
                ->where('username', $username)
                ->whereIn('batch_group', ['BNI_CREDIT', 'BNI_DEBIT'])
                ->orderByDesc('id')
                ->get();

            $creditDebitReady = $cdcpUsers->count() >= 2;
            $creditDebitTid = $creditDebitReady ? $cdcpUsers->first()->tid : null;
            
            $merchantMid = DB::connection('cdcp')
                ->table('merchant_mid')
                ->where('merchant_id', 125)
                ->orderByDesc('id')
                ->value('mid');

            // === QRPS ===
            $qrpsReady = DB::connection('qrps')
                ->table('device_user_detail')
                ->where('username', $username)
                ->exists();

            // === Mini ATM ===
            $miniAtm = DB::connection('mini_atm')
                ->table('user_detail')
                ->where('username', $username)
                ->orderByDesc('id')
                ->first();

            $miniAtmReady = (bool) $miniAtm;
            $miniAtmTid = $miniAtm?->tid;

            // === BNPL ===
            $bnplReady = DB::connection('bnpl')
                ->table('device_user_detail')
                ->where('username', $username)
                ->exists();

        } catch (\Throwable $e) {
            report($e);
        }

        return view('dashboard', compact(
            'creditDebitReady','qrpsReady','miniAtmReady',
            'creditDebitTid','miniAtmTid','merchantMid','bnplReady'
        ));
    }

}