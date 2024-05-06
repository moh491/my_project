<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Experience extends Model
{
    use HasFactory;
    protected $fillable= [
        'company_name',
        'employment_type',
        'location_type',
        'location',
        'start_date',
        'end_date',
        'position_id',
        'company_id',
        'freelancer_id',
        'description'
    ];

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
