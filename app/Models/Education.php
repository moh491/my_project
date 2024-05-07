<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Education extends Model
{
    use HasFactory;
    protected $fillable=[
        'title',
        'institution',
        'location',
        'start_year',
        'end_year',
        'average',
        'description',
        'freelancer_id'


    ];
    public function freelancer(){
        return $this->belongsTo(Freelancer::class);
    }
}
