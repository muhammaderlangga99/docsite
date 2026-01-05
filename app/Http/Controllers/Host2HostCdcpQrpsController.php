<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Host2HostCdcpQrpsController extends Controller
{
    public function __invoke(Request $request)
    {
        $user = $request->user();
        $username = $user?->username;
        $cdcpTid = null;
        $qrisTid = null;

        if ($username) {
            try {
                $cdcpTid = DB::connection('cdcp')
                    ->table('user_detail')
                    ->where('username', $username)
                    ->whereIn('batch_group', ['BNI_CREDIT', 'BNI_DEBIT'])
                    ->orderByDesc('id')
                    ->value('tid');

                $additionalParam = DB::connection('qrps')
                    ->table('device_user_and_batch_group')
                    ->where('username', $username)
                    ->orderByDesc('id')
                    ->value('additional_param');

                if ($additionalParam) {
                    $payload = json_decode($additionalParam, true);
                    if (is_array($payload)) {
                        $qrisTid = $payload['request_body']['terminalId'] ?? null;
                    }
                }
            } catch (\Throwable $e) {
                report($e);
            }
        }

        return view('host2host.cdcp-qrps', [
            'user' => $user,
            'host' => 'https://tucanos-miniatm.cashlez.com',
            'password' => '123456',
            'cdcpTid' => $cdcpTid,
            'qrisTid' => $qrisTid,
        ]);
    }
}
