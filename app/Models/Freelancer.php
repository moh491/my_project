<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
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
    ];

    public function scopeName(Builder $query, $name)
    {
        return $query->where('first_name', 'like', "%{$name}%")
            ->orWhere('last_name', 'like', "%{$name}%");
    }

    //Get the freelancer's only otp.
    public function otps()
    {
        return $this->morphOne(Otp::class, 'otpable');
    }
    public function position(){
        return $this->belongsTo(Position::class);
    }
    public function field(){
        return $this->belongsTo(Field::class);
    }
    public function experiences(){
        return $this->hasMany(Experience::class);
    }
    public function certifications(){
        return $this->hasMany(Certification::class);
    }
    public function languages(){
        return $this->hasMany(Language::class);
    }
    public function eductions(){
        return $this->hasMany(Education::class);
    }


    public function jobs(){
        return $this->belongsToMany(Job::class,'applications');
    }
    public function teams(){
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
   public function portfolios(){
        return $this->morphToMany(Portfolio::class,'owner','owner__portfolios');
   }

    //Get all of the freelancer's services
    public function services(){
        return $this->morphMany(Service::class,'owner');
    }




}
