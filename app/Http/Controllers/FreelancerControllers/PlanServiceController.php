<?php

namespace App\Http\Controllers\FreelancerControllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\PlanRequest;
use App\Http\Requests\PlanUpdateRequest;
use App\Http\Requests\ServiceUpdateRequest;
use App\Models\Plan;
use App\Models\Service;
use App\Services\PlanService;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PlanServiceController extends Controller
{
    use ApiResponseTrait;
    protected $planService;

    public function __construct(PlanService $planService)
    {
        $this->planService = $planService;
    }
    public function insert(PlanRequest $request,$serviceID){
        try {
            $validator = $request->validated();
            $service=Service::find($serviceID);
            if(! Auth::guard('Freelancer')->user()->can('access', [ Plan::class,$service] ) ) {
                return $this->error('not authorized');
            }
            $this->planService->create($serviceID,$validator);
            return $this->success('insert plan successfully');
        }
        catch (\throwable $throwable){
            return $this->serverError($throwable->getMessage());
        }
    }
    public function delete($id){
        try {
            $plan = Plan::find($id);
            $service= Service::find($plan->service_id);
            if(! Auth::guard('Freelancer')->user()->can('access', [ Plan::class,$service] ) ) {
                return $this->error('not authorized');
            }
            $this->planService->delete($id);
            return $this->success('delete plan successfully');
        }
        catch (\throwable $throwable){
            return $this->serverError($throwable->getMessage());
        }
    }
    public function update(PlanUpdateRequest $request,$id){
        try {
            $validator = $request->validated();
            $plan = Plan::find($id);
            $service= Service::find($plan->service_id);
            if(! Auth::guard('Freelancer')->user()->can('access', [ Plan::class,$service] ) ) {
                return $this->error('not authorized');
            }
            $this->planService->update($id,$validator);
            return $this->success('update plan successfully');
        }
        catch (\throwable $throwable){
            return $this->serverError($throwable->getMessage());
        }
    }

}
