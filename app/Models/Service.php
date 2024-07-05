<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Service extends Model
{
    use HasFactory;
    protected $fillable=[
       'title',
       'description',
       'image',
        'owner_type',
        'owner_id',
        'preview'
    ];
    public function plans(){
        return $this->hasMany(Plan::class);
    }
    public function features(){
        return $this->hasMany(Feature::class);
    }
    //Get all of the skills for the service.
    public function skills(){
        return $this->morphToMany(Skill::class, 'skillable','skillable__skills');
    }

    //Get all of the models that own service.
    public function owner(){
        return $this->morphTo();
    }


}
