<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Request extends Model
{
    use HasFactory;
    public function delivery_options(){
        return $this->belongsTo(Delivery_Option::class);
    }
}
