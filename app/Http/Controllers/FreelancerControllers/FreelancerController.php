<?php

namespace App\Http\Controllers\FreelancerControllers;

use App\Http\Requests\AboutRequest;
use App\Http\Resources\FreeResource;
use App\Models\Freelancer;
use App\Models\Portfolio;
use App\Services\FreelancerService;
use App\Traits\ApiResponseTrait;
use Illuminate\Support\Facades\Auth;

class FreelancerController
{
    use ApiResponseTrait;
    protected $freelancerService;

    public function __construct(FreelancerService $freelancerService)
    {
        $this->freelancerService = $freelancerService;
    }
    public function getBasicInformation($id=null){
        try {
            if(!$id){
                $id = Auth::guard('Freelancer')->user()->id;
            }
            $information = $this->freelancerService->basicInformation($id);
            return $this->success('get basic information',$information);
        }
         catch (\throwable $throwable){
            return $this->serverError($throwable->getMessage());
        }
    }

    public function getReviews($id =null){
            if(!$id){
                $id = Auth::guard('Freelancer')->user()->id;
            }
            $information = $this->freelancerService->getReviews($id);
            return $this->success('get reviews',$information);


    }
    public function updateAbout(AboutRequest $request){
        try {
            $validator = $request->validated();
            $this->freelancerService->updateAbout($validator);
            return $this->success('updated successfully');
        }
        catch (\throwable $throwable){
            return $this->serverError($throwable->getMessage());
        }

    }
    public function index(): \Illuminate\Http\JsonResponse
    {
        try {
            $id=Auth::guard('Freelancer')->user()->id;
            $freelancer= FreeResource::collection(Freelancer::where('id', '!=', $id)->get());
            return $this->success('get freelancers', $freelancer);
        } catch (\throwable $throwable) {
            return $this->serverError($throwable->getMessage());
        }
    }

}
