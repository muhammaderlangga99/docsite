<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Throwable;

class QrpsController extends Controller
{
    public function __invoke(Request $request): RedirectResponse
    {
        $user = $request->user();

        if (! $user?->username) {
            return back()->with('error', 'Username tidak tersedia. Silakan set username terlebih dahulu.');
        }

        $username = $user->username;

        try {
            DB::connection('qrps')->beginTransaction();

            $this->upsertDeviceUserDetail($username);
            $this->upsertDeviceUserAndBatchGroup($username);

            DB::connection('qrps')->commit();
        } catch (Throwable $e) {
            DB::connection('qrps')->rollBack();
            report($e);

            throw ValidationException::withMessages([
                'username' => 'Gagal menyimpan data QRPS. Silakan coba lagi.',
            ]);
        }

        return back()->with('success', 'QRPS berhasil disimpan untuk username '.$username.'.');
    }

    private function upsertDeviceUserDetail(string $username): void
    {
        DB::connection('qrps')->table('device_user_detail')->updateOrInsert(
            ['username' => $username],
            [
                'invoice_num' => 0,
                'additional_param' => '',
                'lock_flag' => 0,
                'trx_via_payment_app_flag' => 1,
                'create_at' => now(),
            ]
        );
    }

    private function upsertDeviceUserAndBatchGroup(string $username): void
    {
        $additional = [
            'request_body' => [
                'storeId' => 'ID2023304913124',
                'terminalId' => '36756626',
                'additionalInfo' => [
                    'tip' => '0.00',
                    'muid' => $username,
                    'bankFreePercentage' => 0,
                    'channelFeePercentage' => 0,
                    'taxPercentage' => 0,
                    'latitude' => '0.0',
                    'longitude' => '0.0',
                    'altitude' => '0.0',
                ],
            ],
            'response_body' => '',
        ];

        DB::connection('qrps')->table('device_user_and_batch_group')->updateOrInsert(
            [
                'username' => $username,
                'batch_group_id' => 11,
            ],
            [
                'batch_num' => 1,
                'rrn' => 0,
                'additional_param' => json_encode($additional),
                'is_downloaded' => 1,
                'trx_via_payment_app_flag' => 0,
                'create_at' => now(),
            ]
        );
    }
}
