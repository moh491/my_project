<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

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
        'field_id',
        'position_id',
        'about'
    ];

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

    public function GenerateCode(){

        $this->timestamps=false;
        $this->code=rand(1000,9999);
        $this->expire_at=now()->addMinute(20);
        $this->save();

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
