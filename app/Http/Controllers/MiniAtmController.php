<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Throwable;

class MiniAtmController extends Controller
{
    public function __invoke(Request $request): RedirectResponse
    {
        $user = $request->user();

        if (! $user?->username) {
            return back()->with('error', 'Username tidak tersedia. Silakan set username terlebih dahulu.');
        }

        $username = $user->username;

        try {
            DB::connection('mini_atm')->beginTransaction();

            $existing = DB::connection('mini_atm')
                ->table('user_detail')
                ->where('username', $username)
                ->lockForUpdate()
                ->first();

            if ($existing) {
                DB::connection('mini_atm')->commit();

                return back()->with('success', 'MiniATM sudah aktif. TID: '.$existing->tid);
            }

            $tid = $this->nextTid();

            DB::connection('mini_atm')->table('user_detail')->insert([
                'merchant_mid_id' => 97,
                'batch_group' => 'AJ_MINI_ATM_SIMULATOR',
                'transaction_channel_id' => 'AJ_MA_TRX_SIMULATOR',
                'username' => $username,
                'tid' => $tid,
                'batch_num' => 1,
                'pin_block_mk' => 'CE262A3D735EA2FB2C6D1CDCB66131A2',
                'pin_block_wk' => 'CE262A3D735EA2FB2C6D1CDCB66131A2',
                'last_credit_debit_user_detail_update_timestamp' => now(),
                'need_tlmk_dwl_flag' => 0,
                'settlement_session_num' => 0,
                'additional_param' => json_encode(['hsm' => 'HSM_LAB', 'mode_bytes' => false]),
                'additional_key' => json_encode([
                    'zpkUnderZmk_kcv' => '45C96D',
                    'tpkUnderTmk_kcv' => 'DBCDEE',
                    'pinBlockMk' => 'CE262A3D735EA2FB2C6D1CDCB66131A2',
                    'zpkUnderLmk' => '266026AE7B2FF559252332B6916A40C3',
                    'zpkUnderZmk' => '10B024162F83DBEA6E3E660EF2D99AE9',
                    'tpkUnderLmk' => 'EAEC1676AFEF934B7D9EBD4CA3511280',
                    'clearTpk' => 'CE262A3D735EA2FB2C6D1CDCB66131A2',
                    'pinBlockWk' => 'CE262A3D735EA2FB2C6D1CDCB66131A2',
                    'zpkUnderLmk_kcv' => '45C96D',
                    'tpkUnderTmk' => 'FCCDDF348E531F6420AE0D33B53C2308',
                ]),
            ]);

            DB::connection('mini_atm')->commit();
        } catch (Throwable $e) {
            DB::connection('mini_atm')->rollBack();
            report($e);

            throw ValidationException::withMessages([
                'username' => 'Gagal mengaktifkan MiniATM. Silakan coba lagi.',
            ]);
        }

        return back()->with('success', 'MiniATM aktif untuk username '.$username.'. TID: '.$tid);
    }

    private function nextTid(): string
    {
        $lastTid = DB::connection('mini_atm')
            ->table('user_detail')
            ->orderByDesc('id')
            ->lockForUpdate()
            ->value('tid');

        $next = ((int) ($lastTid ?? 0)) + 1;

        return str_pad((string) $next, 8, '0', STR_PAD_LEFT);
    }
}
