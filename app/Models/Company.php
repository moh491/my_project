<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Company extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $fillable = [
        'name',
        'logo',
        'email',
        'password',
        'field_id',
        'about',
        'location',
        'background_image',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function otps()
    {
        return $this->morphOne(Otp::class, 'otpable');
    }

    public function field(){
        return $this->belongsTo(Field::class);
    }
    public function experiences(){
        return $this->hasMany(Experience::class);
    }
}
