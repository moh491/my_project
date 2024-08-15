<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;
    protected $fillable=[
        'name',
        'logo',
        'link',
        'about',
        'withdrawal_balance',
        'available_balance',
        'suspended_balance'
    ];
    public $timestamps = true;

    public function freelancers(){
        return $this->belongsToMany(Freelancer::class,'freelancer__teams')->withPivot('position_id', 'is_owner')
            ->withTimestamps();
    }
    //Get all of the team's projects
    public function projects(){
        return $this->morphMany(Project::class,'worker');
    }

    //Get all of the team's offers
    public function offers(){
        return $this->morphMany(Offer::class,'worker');
    }

    //Get all of the skills for the team.
    public function skills(){
        return $this->morphToMany(Skill::class, 'skillable','skillable__skills');
    }

    //Get all of the portfolios for the team.
    public function portfolios(){
        return $this->morphToMany(Portfolio::class,'owner','owner__portfolios');
    }

    //Get all of the team's services
    public function services(){
        return $this->morphMany(Service::class,'owner');
    }

}
