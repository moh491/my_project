<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Experience extends Model
{
    use HasFactory;

    public function freelancer(){
        return $this->belongsTo(Freelancer::class);
    }
    public function position(){
        return $this->belongsTo(Position::class);
    }
    public function company(){
        return $this->belongsTo(Company::class);
    }


}
