<?php

namespace App\Http\Controllers\FreelancerControllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\ServiceRequest;
use App\Http\Requests\ServiceUpdateRequest;
use App\Models\Service;
use App\Models\Team;
use App\Services\FreelancerService;
use App\Services\ServicesService;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;
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

    public function insertService(ServiceRequest $request,$id=null){
        try {
            if($id) {
                $type='App\\Models\\Team';
            }else{
                $type='App\\Models\\Freelancer' ;
                $id = Auth::guard('Freelancer')->user()->id;
            }
            $validator = $request->validated();
            if($type=='App\\Models\\Team'){
                $team = Team::find($id);
                $freelancer=Auth::guard('Freelancer')->user();
                if(!$team->freelancers->contains($freelancer->id)){
                    return $this->error('not authorized');
                }
            }
            $this->servicesService->createService($id,$type,$validator);
            return $this->success('insert service successfully');
        }
        catch (\throwable $throwable){
            return $this->serverError($throwable->getMessage());
        }
    }
    public function update(ServiceUpdateRequest $request,string $id,$teamId=null){
        try {
            $data = $request->validated();
            $service=Service::find($id);
            if( Auth::guard('Freelancer')->user()->can('update', [ Service::class, $service,$teamId ] ) ){
                $this->servicesService->update($id,$data);
                return $this->success('updated successful');
            }else{
                return $this->error('not authorized');
            }
        }
        catch (\throwable $throwable){
            return $this->serverError($throwable->getMessage());
        }
    }
    public function delete($id,$teamId=null){
        try {
            $service=Service::find($id);
            if( Auth::guard('Freelancer')->user()->can('delete', [ Service::class, $service,$teamId ] ) ){
                $this->servicesService->delete($id);
                return $this->success('deleted successful');
            }else{
                return $this->error('not authorized');
            }
        }
        catch (\throwable $throwable){
            return $this->serverError($throwable->getMessage());
        }
    }





}
