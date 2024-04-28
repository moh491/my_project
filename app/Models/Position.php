<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Position extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function freelancer(){
        return $this->hasMany(Freelancer::class);
    }

    public function experiences(){
        return $this->hasMany(Experience::class);
    }
    public function freelancer_team(){
        return $this->hasMany(Freelancer_Team::class);
    }
    public function field(){
        return $this->belongsTo(Field::class);
    }

}
