<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
    ];
  //Get all of the freelancers that are assigned this skill.
    public function freelancers()
    {
        return $this->morphedByMany(Freelancer::class, 'skillable','skillable__skills');
    }
    //Get all of the projects that are assigned this skill.
    public function projects(){
        return $this->morphedByMany(Project::class,'skillable','skillable__skills');
    }

    //Get all of the teams that are assigned this skill.
    public function teams(){
        return $this->morphedByMany(Team::class,'skillable','skillable__skills');
    }

    //Get all of the services that are assigned this skill.
    public function services(){
        return $this->morphedByMany(Service::class,'skillable','skillable__skills');
    }




}
