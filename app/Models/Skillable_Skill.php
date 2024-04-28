<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Skillable_Skill extends Model
{
    use HasFactory;
    protected $fillable = [
        'skillable_type',
        'skillable_id',
        'skill_id',
    ];

}
