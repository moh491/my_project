<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    use HasFactory;
    protected $fillable=[
        'price',
        'description',
        'type',
        'service_id'


    ];
    public function service(){
        return $this->belongsTo(Service::class);
    }
    public function delivery_options(){
        return $this->hasMany(Delivery_Option::class);
    }
    public function features(){
        return $this->belongsToMany(Feature::class,'plan__features')->withPivot('value');
    }
}
