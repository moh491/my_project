<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;


class Request extends Model
{
    use HasFactory;
    protected $fillable=[
       'note',
        'files',
        //'budget',
        'status',
        'project_owner_id',
        'plan_id',
        'rating'
    ];
    public function plan(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Plan::class);
    }

    public function project_owners(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Project_Owners::class,'project_owner_id');
    }
}
