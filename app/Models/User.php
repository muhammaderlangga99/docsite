<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [ 
        'name',
        'email',
        'password',
        'username',
        'google_id',
        'avatar',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Generate a unique username based on a name (uses last word if available).
     */
    public static function generateUniqueUsername(string $name): string
    {
        $cleanName = trim($name);
        $parts = array_values(array_filter(preg_split('/\s+/', $cleanName)));
        $base = count($parts) ? $parts[count($parts) - 1] : $cleanName;
        // Keep letters, then lowercase at the end (do not strip uppercase letters).
        $base = strtolower(preg_replace('/[^a-z0-9]/i', '', $base));
        if ($base === '') {
            $base = 'user';
        }

        do {
            $username = $base . rand(100, 999);
        } while (static::where('username', $username)->exists());

        return $username;
    }

    /**
     * Pastikan user_details di DB bridge ada untuk user ini.
     */
    public function ensureBridgeUserDetail(): void
    {
        if (empty($this->username)) {
            return;
        }

        $exists = DB::connection('bridge')
            ->table('user_details')
            ->where('username', $this->username)
            ->exists();

        if (! $exists) {
            DB::connection('bridge')->table('user_details')->insert([
                'username' => $this->username,
                'client_id' => 'CLID-9512DD2103143019',
                'create_at' => now(),
                'ws_token' => null,
            ]);
        }
    }

    /**
     * Pastikan entry mobile_app_users di DB master ada untuk user ini.
     */
    public function ensureMasterMobileUser(): void
    {
        if (empty($this->username)) {
            return;
        }

        $exists = DB::connection('master')
            ->table('mobile_app_users')
            ->where('username', $this->username)
            ->exists();

        if ($exists) {
            return;
        }

        $fullName = trim($this->name ?? '');
        $parts = array_values(array_filter(preg_split('/\s+/', $fullName)));
        $firstName = $parts[0] ?? $fullName ?: $this->username;
        $lastName = isset($parts[1]) ? implode(' ', array_slice($parts, 1)) : null;

        $address = 'Jl. Jenderal Sudirman Kav. 33A';
        $receiptLine1 = 'Jl. Jenderal Sudirman Kav. 33A';
        $receiptLine2 = 'Jakarta Pusat, Tanah Abang';

        DB::connection('master')->table('mobile_app_users')->insert([
            'username' => $this->username,
            'merchant_id' => 125,
            'passwd_hash' => md5('123456'),
            'first_name' => $firstName,
            'last_name' => $lastName,
            'address' => $address,
            'print_receipt_merchant_name' => 'TOKO TEST',
            'print_receipt_address_line_1' => $receiptLine1,
            'print_receipt_address_line_2' => $receiptLine2,
            'stan' => 0,
            'invoice_num' => 0,
            'last_user_data_update_timestamp' => null,
            'is_payment_application_unattended' => null,
            'lock_flag' => 0,
            'pos_request_type' => '1',
            'pos_vendor_id' => null,
            'created_at' => now(),
            'updated_at' => now(),
            'deleted_at' => null,
        ]);
    }
}
