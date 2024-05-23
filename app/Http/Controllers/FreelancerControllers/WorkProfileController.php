<?php

namespace App\Http\Controllers\FreelancerControllers;

use App\Http\Controllers\Controller;
use App\Services\FreelancerService;
use App\Services\WorkProfileService;
use App\Traits\ApiResponseTrait;
use Illuminate\Support\Facades\Auth;

class WorkProfileController extends Controller
{
    use ApiResponseTrait;
    public function getWorkProfile(WorkProfileService $workProfileService,$id=null){
        try {
            if(!$id){
                $id = Auth::guard('Freelancer')->user()->id;
            }
            $information = $workProfileService->workProfile($id);
            return $this->success('get work profile',$information);
        }
        catch (\throwable $throwable){
            return $this->serverError($throwable->getMessage());
        }
    }


}
