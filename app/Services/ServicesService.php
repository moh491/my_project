<?php

namespace App\Services;

use App\Http\Resources\ServiceResource;
use App\Models\Freelancer;

class ServicesService
{
    public function getServices(string $id){
        $freelancer = Freelancer::find($id);
        $services = $freelancer->services;
        return ServiceResource::collection($services);
    }

}
