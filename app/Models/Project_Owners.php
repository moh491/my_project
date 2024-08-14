<?php

namespace App\Models;

use App\Http\Middleware\Authenticate;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Project_Owners extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'about',
        'location',
        'time_zone',
        'profile',
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


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
    public function otps()
    {
        return $this->morphOne(Otp::class, 'otpable');
    }

    public function fields()
    {
        return $this->belongsToMany(Field::class, 'field__project_owners', 'project__owners_id', 'field_id');
    }
    public function Projects(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Project::class,'project_owner_id');
    }
    public function requests(){
        return $this->hasMany(Request::class,'project_owner_id');
    }

    public function payments(): \Illuminate\Database\Eloquent\Relations\MorphMany
    {
        return $this->morphMany(Payment::class,'owner');
    }

}
