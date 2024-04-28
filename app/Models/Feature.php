<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feature extends Model
{
    use HasFactory;
    public function service(){
        return $this->belongsTo(Service::class);
    }
    public function plans(){
        return $this->belongsToMany(Plan::class,'plan__features');
    }
}
