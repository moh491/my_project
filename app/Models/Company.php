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
        'suspended_balance',
        'withdrawal_balance'
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

    public function otps(): \Illuminate\Database\Eloquent\Relations\MorphOne
    {
        return $this->morphOne(Otp::class, 'otpable');
    }


    public function field(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Field::class);
    }


    public function experiences(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Experience::class);
    }


    public function jobs(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(CompanyJob::class);
    }


    public function payments(): \Illuminate\Database\Eloquent\Relations\MorphMany
    {
        return $this->morphMany(Payment::class,'owner');
    }

}
