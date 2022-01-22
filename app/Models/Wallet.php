<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Wallet extends ModelUuid
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'user_id',
        'balance'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }
}
