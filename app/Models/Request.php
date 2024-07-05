<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Request extends Model
{
    use HasFactory;
    protected $fillable=[
       'note',
        'files',
        'budget',
        'status',
        'project_owner_id',
        'delivery_option_id',
        'rating'
    ];
    public function delivery_options(){
        return $this->belongsTo(Delivery_Option::class);
    }
}
