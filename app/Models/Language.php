<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    use HasFactory;
    protected $fillable=[
      'language',
        'level',
        'freelancer_id'
    ];

    public function freelancer(){
        return $this->belongsTo(Freelancer::class);
    }
}
