<?php

namespace App\Http\Controllers\FreelancerControllers;

use App\Http\Controllers\Controller;
use App\Services\FreelancerService;
use App\Services\ServicesService;
use App\Traits\ApiResponseTrait;

class ServiceController extends Controller
{
    use ApiResponseTrait;
    public function getServices(string $id,ServicesService $servicesService){
        try {
            $information = $servicesService->getServices($id);
            return $this->success('get services',$information);
        }
        catch (\throwable $throwable){
            return $this->serverError($throwable->getMessage());
        }
    }

}
