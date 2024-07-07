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
        'project_owner_id'

    ];

    public function project_owners(){
        return $this->belongsTo(Project_Owners::class);
    }
}
