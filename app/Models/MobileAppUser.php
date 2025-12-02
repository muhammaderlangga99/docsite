<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MobileAppUser extends Model
{
    protected $connection = 'master';

    protected $table = 'mobile_app_users';

    protected $primaryKey = 'username';

    public $incrementing = false;

    protected $keyType = 'string';

    public $timestamps = false;

    protected $fillable = [
        'username',
        'merchant_id',
        'passwd_hash',
        'first_name',
        'last_name',
        'address',
        'print_receipt_merchant_name',
        'print_receipt_address_line_1',
        'print_receipt_address_line_2',
        'lock_flag',
        'pos_request_type',
        'created_at',
    ];
}
