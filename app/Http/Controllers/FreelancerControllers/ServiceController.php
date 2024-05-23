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
    protected $servicesService;

    public function __construct(ServicesService $servicesService)
    {
        $this->servicesService = $servicesService;
    }
    public function getServices($id =null,$type=null){
        try {
            ($type=="team")?$model=$model='App\\Models\\Team':$model='App\\Models\\Freelancer';
            if(!$id){
                $id = Auth::guard('Freelancer')->user()->id;
                $model='App\\Models\\Freelancer';
            }
            $information = $this->servicesService->getServices($id,$model);
            return $this->success('get services',$information);
        }
        catch (\throwable $throwable){
            return $this->serverError($throwable->getMessage());
        }
    }
    public function detailService($id){
        try {
            $information = $this->servicesService->detailServices($id);
            return $this->success('get details service',$information);
        }
        catch (\throwable $throwable){
            return $this->serverError($throwable->getMessage());
        }
    }



}
