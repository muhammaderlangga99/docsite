<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Database\Connection;
use RuntimeException;
use Throwable;

class MiniAtmCredentialService
{
    private const MERCHANT_ID = 125;
    private const PRIVATE_KEY_WARNING = 'Private key ini hanya ditampilkan sekali. Harap simpan dengan aman.';

    /**
     * Generate partner, client, and partner_token, and return credentials + private key.
     */
    public function generateCredentials(string $username): array
    {
        return $this->connection()->transaction(function () use ($username) {
            $conn = $this->connection();
            $apiKey = $this->generateApiKey();

            $partnerId = $conn->table('partner')->insertGetId([
                'name' => $username,
                'api_key' => $apiKey,
                'state' => 'Active',
                'code' => null,
                'payment_channel' => 1,
                'updated_at' => now(),
            ]);

            $clientId = $this->generateClientId();
            $conn->table('client')->insert([
                'id' => $clientId,
                'partner_id' => $partnerId,
                'merchant_id' => self::MERCHANT_ID,
                'state' => 'Active',
                'updated_at' => now(),
            ]);

            [$privateKey, $publicKey] = $this->generateKeyPair();
            $cleanPublicKey = $this->cleanPublicKey($publicKey);

            $conn->table('partner_token')->updateOrInsert(
                ['partner_id' => $partnerId],
                ['pub_key' => $cleanPublicKey, 'token' => null]
            );

            return [
                'partner_id' => $partnerId,
                'api_key' => $apiKey,
                'client_id' => $clientId,
                'private_key' => $privateKey,
                'public_key' => $cleanPublicKey,
                'warning' => self::PRIVATE_KEY_WARNING,
            ];
        });
    }

    public function getLatestCredentialsForUser(string $username): ?object
    {
        return $this->connection()
            ->table('partner as p')
            ->join('client as c', 'c.partner_id', '=', 'p.id')
            ->leftJoin('partner_token as pt', 'pt.partner_id', '=', 'p.id')
            ->where('p.name', $username)
            ->orderByDesc('p.id')
            ->select([
                'p.id as partner_id',
                'p.name as partner_name',
                'p.api_key',
                'c.id as client_id',
                'pt.pub_key',
            ])
            ->first();
    }

    /**
     * Regenerate key pair for an existing partner_token row.
     */
    public function regenerateKey(int $partnerId): array
    {
        return $this->connection()->transaction(function () use ($partnerId) {
            $conn = $this->connection();
            [$privateKey, $publicKey] = $this->generateKeyPair();
            $cleanPublicKey = $this->cleanPublicKey($publicKey);

            $conn->table('partner_token')->updateOrInsert(
                ['partner_id' => $partnerId],
                ['pub_key' => $cleanPublicKey, 'token' => null]
            );

            return [
                'partner_id' => $partnerId,
                'private_key' => $privateKey,
                'public_key' => $cleanPublicKey,
                'warning' => self::PRIVATE_KEY_WARNING,
            ];
        });
    }

    private function generateApiKey(): string
    {
        return strtoupper(bin2hex(random_bytes(25)));
    }

    private function generateClientId(): string
    {
        return 'CLID-' . Str::upper(Str::random(30));
    }

    /**
     * @return array{0:string,1:string} [privateKey, publicKey]
     */
    private function generateKeyPair(): array
    {
        $configPath = config_path('openssl.cnf');
        $options = [
            'private_key_bits' => 2048,
            'private_key_type' => OPENSSL_KEYTYPE_RSA,
        ];

        if (file_exists($configPath)) {
            $options['config'] = $configPath;
        }

        try {
            $res = openssl_pkey_new($options);
        } catch (Throwable $e) {
            throw new RuntimeException('Gagal membuat key pair', 0, $e);
        }

        if (! $res) {
            $errors = [];
            while ($msg = openssl_error_string()) {
                $errors[] = $msg;
            }
            $errorMessage = $errors ? implode(' | ', $errors) : 'Unknown OpenSSL error';
            throw new RuntimeException('Gagal membuat key pair: '.$errorMessage);
        }

        $privateKey = null;
        openssl_pkey_export($res, $privateKey, null, $options);

        $details = openssl_pkey_get_details($res);
        $publicKey = $details['key'] ?? null;

        if (! $privateKey || ! $publicKey) {
            throw new RuntimeException('Key pair tidak lengkap');
        }

        return [$privateKey, $publicKey];
    }

    private function cleanPublicKey(string $pem): string
    {
        $stripped = preg_replace('/-----BEGIN PUBLIC KEY-----|-----END PUBLIC KEY-----/', '', $pem);
        $stripped = str_replace(["\r", "\n", ' '], '', (string) $stripped);

        return trim($stripped);
    }

    private function connection(): Connection
    {
        return DB::connection('host_to_host');
    }

    public function isPartnerOwnedByUser(int $partnerId, string $username): bool
    {
        return $this->connection()
            ->table('partner')
            ->where('id', $partnerId)
            ->where('name', $username)
            ->exists();
    }
}
