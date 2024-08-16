<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    use HasFactory;
    protected $fillable=[
        'duration',
        'budget',
        'description',
        'status',
        'files',
        'project_id',
        'worker_type',
        'worker_id',

    ];

    protected $guarded=[];
     //Get the project that are assigned this offer
    public function project(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Project::class);
    }
    //Get all of the models that own offers.
    public function worker(): \Illuminate\Database\Eloquent\Relations\MorphTo
    {
        return $this->morphTo();
    }

//    protected $attributes = [
//        'worker_type' => 'App\Models\Freelancer',
//    ];




}
