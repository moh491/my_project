<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
    protected $fillable=[
        'session_id',
        'refund_id',
        'status',
        'amount',
        'owner_type',
        'owner_id'

    ];

//    public function project_owners(){
//        return $this->belongsTo(Project_Owners::class);
//    }

    public function owner()
    {
        return $this->morphTo();
    }
}
