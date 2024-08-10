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
        'delivery_option_id',
        'rating'
    ];
    public function delivery_options(){
        return $this->belongsTo(Delivery_Option::class);
    }
    public function project_owners(){
        return $this->belongsTo(Project_Owners::class);
    }
}
