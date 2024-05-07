<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Certification extends Model
{
    use HasFactory;
    protected $fillable=[
        'title',
        'start_date',
        'end_date',
        'credentials_id',
        'image',
        'link',
        'freelancer_id'
    ];
    public function freelancer(){
        return $this->belongsTo(Freelancer::class);
    }
}
