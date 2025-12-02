<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class User extends Authenticatable implements MustVerifyEmail
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
            throw new \RuntimeException('Username tidak tersedia untuk sinkronisasi ke master.');
        }

        $exists = DB::connection('master')
            ->table('mobile_app_users')
            ->where('username', $this->username)
            ->exists();

        if ($exists) {
            return;
        }

        [$firstName, $lastName] = $this->splitName();

        DB::connection('master')->table('mobile_app_users')->insert([
            'username' => $this->username,
            'merchant_id' => 125,
            'passwd_hash' => 'e10adc3949ba59abbe56e057f20f883e',
            'first_name' => $firstName,
            'last_name' => $lastName,
            'address' => 'ATRIA @SUDIRMAN',
            'print_receipt_merchant_name' => 'cashUP (Testing)',
            'print_receipt_address_line_1' => 'Jl. Jenderal Sudirman',
            'print_receipt_address_line_2' => 'Tanah Abang, Jakarta Pusat',
            'is_payment_application_unattended' => null,
            'lock_flag' => 0,
            'pos_request_type' => '1',
            'created_at' => now(),
        ]);
    }

    private function splitName(): array
    {
        $fullName = trim($this->name ?? '');
        $parts = array_values(array_filter(preg_split('/\s+/', $fullName)));

        if (count($parts) === 0) {
            return [$this->username, null];
        }

        $firstName = $parts[0];
        $lastName = count($parts) > 1 ? implode(' ', array_slice($parts, 1)) : null;

        return [$firstName, $lastName];
    }
}
