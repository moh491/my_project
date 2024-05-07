<?php

namespace App\Http\Controllers\FreelancerControllers;

use App\Http\Requests\AboutRequest;
use App\Services\FreelancerService;
use App\Traits\ApiResponseTrait;

class FreelancerController
{
    use ApiResponseTrait;
    public function getBasicInformation(string $id,FreelancerService $freelancerService){
        try {
            $information = $freelancerService->basicInformation($id);
            return $this->success('get basic information',$information);
        }
         catch (\throwable $throwable){
            return $this->serverError($throwable->getMessage());
        }
    }

    public function getReviews(string $id,FreelancerService $freelancerService){
        try {
            $information = $freelancerService->getReviews($id);
            return $this->success('get reviews',$information);
        }
        catch (\throwable $throwable){
            return $this->serverError($throwable->getMessage());
        }
    }
    public function updateAbout(AboutRequest $request,string $id,FreelancerService $freelancerService){
        try {
            $validator = $request->validated();
           $freelancerService->updateAbout($id,$validator);
            return $this->success('updated successfully');
        }
        catch (\throwable $throwable){
            return $this->serverError($throwable->getMessage());
        }


    }

}
