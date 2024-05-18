<?php

namespace App\Http\Controllers\FreelancerControllers;

use App\Http\Requests\AboutRequest;
use App\Services\FreelancerService;
use App\Traits\ApiResponseTrait;
use Illuminate\Support\Facades\Auth;

class FreelancerController
{
    use ApiResponseTrait;
    public function getBasicInformation(FreelancerService $freelancerService,$id=null){
        try {
            if(!$id){
                $id=Auth::user()->id;
            }
            $information = $freelancerService->basicInformation($id);
            return $this->success('get basic information',$information);
        }
         catch (\throwable $throwable){
            return $this->serverError($throwable->getMessage());
        }
    }

    public function getReviews(FreelancerService $freelancerService,$id =null){
        try {
            if(!$id){
                $id=Auth::user()->id;
            }
            $information = $freelancerService->getReviews($id);
            return $this->success('get reviews',$information);
        }
        catch (\throwable $throwable){
            return $this->serverError($throwable->getMessage());
        }
    }
    public function updateAbout(AboutRequest $request,FreelancerService $freelancerService){
        try {
            $validator = $request->validated();
           $freelancerService->updateAbout($validator);
            return $this->success('updated successfully');
        }
        catch (\throwable $throwable){
            return $this->serverError($throwable->getMessage());
        }

    }

}
