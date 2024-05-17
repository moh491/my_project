<?php

namespace App\Services;

use App\Http\Resources\ServiceResource;
use App\Models\Freelancer;

class ServicesService
{
    public function getServices(string $id,$model){
        $user = $model::find($id);
        $services = $user->services;
        return ServiceResource::collection($services);
    }

}
