<?php

namespace App\Http\Controllers\FreelancerControllers;

use App\Http\Controllers\Controller;
use App\Services\FreelancerService;
use App\Services\ServicesService;
use App\Traits\ApiResponseTrait;
use Illuminate\Support\Facades\Auth;

class ServiceController extends Controller
{
    use ApiResponseTrait;
    public function getServices(ServicesService $servicesService,$id =null,$type=null){
        try {
            ($type=="team")?$model=$model='App\\Models\\Team':$model='App\\Models\\Freelancer';
            if(!$id){
                $id=Auth::user()->id;
                $model='App\\Models\\Freelancer';
            }
            $information = $servicesService->getServices($id,$model);
            return $this->success('get services',$information);
        }
        catch (\throwable $throwable){
            return $this->serverError($throwable->getMessage());
        }
    }

}
