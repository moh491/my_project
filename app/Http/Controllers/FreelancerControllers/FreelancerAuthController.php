<?php

namespace App\Http\Controllers\FreelancerControllers;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\StoreFreelancerRequset;
use App\Mail\SendCodeEmail;
use App\Models\Freelancer;
use App\Models\Otp;
use App\Services\FreelancerService;
use App\Traits\ApiResponseTrait;
 use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class FreelancerAuthController extends Controller
{

use ApiResponseTrait;

    public function register(StoreFreelancerRequset $request,FreelancerService $freelancerService)
    {
        try {
            $validator = $request->validated();
            $Freelancer = $freelancerService->createFreelancer($validator);
            return $this->success('Register has successful',$Freelancer);
        }
        catch (\throwable $throwable){
            return $this->serverError($throwable->getMessage());
        }
    }


}
