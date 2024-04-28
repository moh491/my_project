<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;
    public function project_owner(){
        return $this->belongsTo(Project_Owners::class);
    }
    public function field(){
        return $this->belongsTo(Field::class);
    }
    public function review()
    {
        return $this->hasOne(Review::class);
    }
   //Get all of the models that own projects.
    public function worker(){
        return $this->morphTo();
    }
    //Get all of the skills for the project.
    public function skills(){
        return $this->morphToMany(Skill::class, 'skillable','skillable__skills');
    }
    //get all of the offers for the project
    public function offers(){
        return $this->hasMany(Offer::class);
    }

}
