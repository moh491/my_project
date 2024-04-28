<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Field extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function freelancers(){
        return $this->hasMany(Freelancer::class);
    }
    public function companies(){
        return $this->hasMany(Company::class);
    }
    public function project_owners(){
        return $this->hasMany(Project_Owners::class);
    }
    public function projects(){
        return $this->hasMany(Project::class);
    }
    public function positions(){
        return $this->hasMany(Position::class);
    }

}
