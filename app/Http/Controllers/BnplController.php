<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Throwable;

class BnplController extends Controller
{
    public function __invoke(Request $request): RedirectResponse
    {
        $user = $request->user();

        if (! $user?->username) {
            return back()->with('error', 'Username tidak tersedia. Silakan set username terlebih dahulu.');
        }

        $username = $user->username;

        try {
            DB::connection('bnpl')->beginTransaction();

            $this->upsertDeviceUserDetail($username);
            $this->upsertDeviceUserAndBatchGroup($username);

            DB::connection('bnpl')->commit();
        } catch (Throwable $e) {
            DB::connection('bnpl')->rollBack();
            report($e);

            throw ValidationException::withMessages([
                'username' => 'Gagal menyimpan data BNPL. Silakan coba lagi.',
            ]);
        }

        return back()->with('success', 'BNPL berhasil disimpan untuk username '.$username.'.');
    }

    private function upsertDeviceUserDetail(string $username): void
    {
        DB::connection('bnpl')->table('device_user_detail')->updateOrInsert(
            ['username' => $username],
            [
                'invoice_num' => 0,
                'additional_param' => '',
                'lock_flag' => 0,
                'trx_via_payment_app_flag' => 0,
                'update_at' => now(),
                'create_at' => now(),
            ]
        );
    }

    private function upsertDeviceUserAndBatchGroup(string $username): void
    {
        $additional = [
            'request_body' => [
                'api_key' => Str::random(32),
                'api_secret' => Str::random(32),
                'api_channel' => (string) Str::uuid(),
            ],
            'response_body' => new \stdClass(),
        ];

        foreach ([1, 2] as $batchGroupId) {
            DB::connection('bnpl')->table('device_user_and_batch_group')->updateOrInsert(
                [
                    'username' => $username,
                    'batch_group_id' => $batchGroupId,
                ],
                [
                    'batch_num' => 0,
                    'rrn' => 0,
                    'additional_param' => json_encode($additional),
                    'is_downloaded' => 1,
                    'trx_via_payment_app_flag' => 0,
                    'update_at' => now(),
                    'create_at' => now(),
                    'deleted_at' => null,
                ]
            );
        }
    }
}
