<?php

namespace App\Services;

use App\Http\Resources\ServiceDetailsResource;
use App\Http\Resources\ServiceResource;
use App\Models\Freelancer;
use App\Models\Service;

class ServicesService
{
    public function getServices(string $id,$model){
        $user = $model::find($id);
        $services = $user->services;
        return ServiceResource::collection($services);
    }
    public function detailServices(string $id){
        $service = Service::find($id);
         return new ServiceDetailsResource($service);
    }

}
