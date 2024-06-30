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


    public function conversations(): \Illuminate\Database\Eloquent\Relations\MorphMany
    {
        return $this->morphMany(Conversation::class, 'source')
            ->orWhere(function ($query) {
                $query->where('destination_type', self::class)
                    ->where('destination_id', $this->id);
            });
    }


    public function sentMessages(): \Illuminate\Database\Eloquent\Relations\MorphMany
    {
        return $this->morphMany(Message::class, 'sender');
    }

    public function receivedMessages(): \Illuminate\Database\Eloquent\Relations\MorphMany
    {
        return $this->morphMany(Message::class, 'receiver');
    }


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
    public function jobs()
    {
        return $this->hasMany(Job::class);
    }

}
