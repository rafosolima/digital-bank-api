<?php

namespace App\Models;

class Transaction extends ModelUuid
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'wallet_id_sended',
        'wallet_id_received',
        'value'
    ];
}
