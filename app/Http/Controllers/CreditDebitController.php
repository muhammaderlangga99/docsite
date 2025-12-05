<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Throwable;

class CreditDebitController extends Controller
{
    public function __invoke(Request $request): RedirectResponse
    {
        $user = $request->user();

        if (! $user?->username) {
            return back()->with('error', 'Username tidak tersedia. Silakan set username terlebih dahulu.');
        }

        $username = $user->username;

        try {
            // Insert ke CDCP (dua baris) + KEK + DEK
            DB::connection('cdcp')->beginTransaction();

            $tid = $this->allocateTid($username);

            $this->insertCreditRow($username, $tid);
            $this->insertDebitRow($username, $tid);

            DB::connection('cdcp')->commit();

            $this->upsertKek($username);
            $this->upsertDek($username);
        } catch (Throwable $e) {
            DB::connection('cdcp')->rollBack();
            report($e);

            throw ValidationException::withMessages([
                'username' => 'Gagal menyimpan data credit/debit. Silakan coba lagi.',
            ]);
        }

        return back()->with('success', 'Credit/Debit berhasil disimpan untuk username '.$username.'. TID: '.$tid);
    }

    private function allocateTid(string $username): string
    {
        // Jika user sudah punya TID, pakai yang sama.
        $existingTid = DB::connection('cdcp')
            ->table('user_detail')
            ->where('username', $username)
            ->orderByDesc('id')
            ->lockForUpdate()
            ->value('tid');

        if ($existingTid) {
            return $existingTid;
        }

        // Ambil TID terbesar, lalu increment sampai dapat yang belum dipakai.
        $maxTid = DB::connection('cdcp')
            ->table('user_detail')
            ->selectRaw('MAX(CAST(tid AS UNSIGNED)) as max_tid')
            ->lockForUpdate()
            ->value('max_tid');

        $candidate = ((int) $maxTid) + 1;

        while (true) {
            $tid = str_pad((string) $candidate, 8, '0', STR_PAD_LEFT);
            $exists = DB::connection('cdcp')
                ->table('user_detail')
                ->where('tid', $tid)
                ->lockForUpdate()
                ->exists();

            if (! $exists) {
                return $tid;
            }

            $candidate++;
        }
    }

    private function insertCreditRow(string $username, string $tid): void
    {
        DB::connection('cdcp')->table('user_detail')->updateOrInsert(
            [
                'batch_group' => 'BNI_CREDIT',
                'transaction_channel_id' => 'BNI_CREDIT_TRX_CHN_1',
                'username' => $username,
                'tid' => $tid,
            ],
            [
                'merchant_mid_id' => 101,
                'batch_num' => 1,
                'pin_block_mk' => '52259D4FFD43DF80',
                'pin_block_wk' => 'AC9B5C039BA26A06',
                'need_tlmk_dwl_flag' => 0,
                'settlement_session_num' => 0,
            ]
        );
    }

    private function insertDebitRow(string $username, string $tid): void
    {
        DB::connection('cdcp')->table('user_detail')->updateOrInsert(
            [
                'batch_group' => 'BNI_DEBIT',
                'transaction_channel_id' => 'BNI_DEBIT_TRX_CHN_1',
                'username' => $username,
                'tid' => $tid,
            ],
            [
                'merchant_mid_id' => 100,
                'batch_num' => 1,
                'pin_block_mk' => '7F43C2B0458A7C25',
                'pin_block_wk' => '0EEFD110F058744D',
                'need_tlmk_dwl_flag' => 0,
                'settlement_session_num' => 0,
            ]
        );
    }

    private function upsertKek(string $username): void
    {
        DB::connection('kek')->table('kek')->updateOrInsert(
            ['username' => $username],
            [
                'key' => 'CCE1ACF2DF9CE15E44C6CADB01D231E4E69D1877AE3869E0748EF4010263A8F4',
                'iv' => '17C4685FD9B8F849E9C27F266A1DBB6F',
                'create_at' => now(),
            ]
        );
    }

    private function upsertDek(string $username): void
    {
        DB::connection('dek')->table('dek')->updateOrInsert(
            ['username' => $username],
            [
                'enc_key' => '04D2BE9EFAE0CDEAB904BB1EB1028692ADA6DF2BF1AFC75334E95F7FB4FB23F4757959E5422CC6925763425D7C5D69D2',
                'iv' => '17C4685FD9B8F849E9C27F266A1DBB6F',
                'create_at' => now(),
            ]
        );
    }
}
