<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;
    protected $fillable=[
        'professionalism',
        'communication',
        'quality',
        'commit_to_deadlines',
        're_employee',
        'experience',
        'description',
        'project_id'

    ];
    public function project(){
        return $this->belongsTo(Project::class);
    }
}
