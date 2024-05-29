<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    use HasFactory;

    protected $guarded=[];
     //Get the project that are assigned this offer
    public function project(){
        return $this->belongsTo(Project::class);
    }
    //Get all of the models that own offers.
    public function worker()
    {
        return $this->morphTo();
    }

//    protected $attributes = [
//        'worker_type' => 'App\Models\Freelancer',
//    ];




}
