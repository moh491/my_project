<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Otp extends Model
{
    use HasFactory;

    protected $fillable = [
        'otp',
        'otp_expiry_time',
        'otpable_type',
        'otpable_id',
    ];

    public function otpable()
    {
        return $this->morphTo();
    }

}
