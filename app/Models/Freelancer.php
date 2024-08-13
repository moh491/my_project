<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Queue\Jobs\Job;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Builder;

class Freelancer extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'code',
        'expire_at',
        'position_id',
        'about',
        'time_zone',
        'location',
        'profile',
        'withdrawal_balance',
        'available_balance',
        'suspended_balance'
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


    public function scopeName(Builder $query, $name)
    {
        return $query->where('first_name', 'like', "%{$name}%")
            ->orWhere('last_name', 'like', "%{$name}%");
    }

    //Get the freelancer's only otp.
    public function otps(): \Illuminate\Database\Eloquent\Relations\MorphOne
    {
        return $this->morphOne(Otp::class, 'otpable');
    }

    public function position(): BelongsTo
    {
        return $this->belongsTo(Position::class);
    }

    public function field(): BelongsTo
    {
        return $this->belongsTo(Field::class);
    }

    public function experiences(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Experience::class);
    }

    public function certifications(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Certification::class);
    }

    public function languages(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Language::class);
    }

    public function eductions(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Education::class);
    }


    public function jobs(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Job::class,'applications');
    }


    public function teams(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Team::class,'freelancer__teams');
    }


    //Get all of the freelancer's projects
    public function projects(){
        return $this->morphMany(Project::class,'worker');
    }

    //Get all of the freelancer's offers
    public function offers(){
        return $this->morphMany(Offer::class,'worker');
    }

    //Get all of the skills for the freelance.
    public function skills(){
        return $this->morphToMany(Skill::class, 'skillable','skillable__skills');
    }

    //Get all of the portfolios for the freelance.
   public function portfolios(): \Illuminate\Database\Eloquent\Relations\MorphToMany
   {
        return $this->morphToMany(Portfolio::class,'owner','owner__portfolios');
   }

    //Get all of the freelancer's services
    public function services(): \Illuminate\Database\Eloquent\Relations\MorphMany
    {
        return $this->morphMany(Service::class,'owner');
    }

    public function applications()
    {
        return $this->hasMany(Application::class);
    }





}
