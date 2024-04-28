<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Delivery_Option extends Model
{
    use HasFactory;
    public function plan(){
        return $this->belongsTo(Plan::class);
    }
    public function requests(){
        return $this->hasMany(Request::class);
    }
}
