<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RedeemVoucher extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class, 'redeem_by', 'id');
    }
}
