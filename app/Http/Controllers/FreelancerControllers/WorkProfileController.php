<?php

namespace App\Http\Controllers\FreelancerControllers;

use App\Http\Controllers\Controller;
use App\Services\FreelancerService;
use App\Services\WorkProfileService;
use App\Traits\ApiResponseTrait;

class WorkProfileController extends Controller
{
    use ApiResponseTrait;
    public function getWorkProfile(string $id,WorkProfileService $workProfileService){
        try {
            $information = $workProfileService->workProfile($id);
            return $this->success('get work profile',$information);
        }
        catch (\throwable $throwable){
            return $this->serverError($throwable->getMessage());
        }
    }


}
