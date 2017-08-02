<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'wallet_address', 'coin_short_name', 'txid', 'time', 'value'
    ];

}
