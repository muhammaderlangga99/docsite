<?php

namespace App\Services;

use Illuminate\Database\Connection;
use Illuminate\Support\Facades\DB;

class EricaCredentialService
{
    private const MERCHANT_ID = 125;

    public function getMerchantDetails(): ?object
    {
        return $this->bridge()
            ->table('merchant_details')
            ->where('merchant_id', self::MERCHANT_ID)
            ->select('id', 'client_id', 'api_key')
            ->first();
    }

    public function resolveCredentials(string $username): array
    {
        $merchant = $this->getMerchantDetails();
        $credentials = null;

        if ($merchant) {
            $userClientId = $this->getUserClientId($username);
            if ($userClientId && $userClientId === $merchant->client_id) {
                $credentials = [
                    'username' => $username,
                    'client_id' => $merchant->client_id,
                    'api_key' => $merchant->api_key,
                ];
            }
        }

        return [
            'credentials' => $credentials,
            'merchant' => $merchant,
        ];
    }

    public function ensureUserDetail(string $username, string $clientId): void
    {
        $this->bridge()->transaction(function () use ($username, $clientId) {
            $conn = $this->bridge();
            $exists = $conn
                ->table('user_details')
                ->where('username', $username)
                ->exists();

            if (! $exists) {
                $conn->table('user_details')->insert([
                    'username' => $username,
                    'client_id' => $clientId,
                    'create_at' => now(),
                    'ws_token' => null,
                ]);

                return;
            }

            $conn
                ->table('user_details')
                ->where('username', $username)
                ->update([
                    'client_id' => $clientId,
                ]);
        });
    }

    private function getUserClientId(string $username): ?string
    {
        $row = $this->bridge()
            ->table('user_details')
            ->where('username', $username)
            ->select('client_id')
            ->first();

        return $row?->client_id;
    }

    private function bridge(): Connection
    {
        return DB::connection('bridge');
    }
}
