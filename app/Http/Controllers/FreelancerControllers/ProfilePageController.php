<?php

namespace App\Http\Controllers\FreelancerControllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\Request;
use App\Services\ProfilePageService;
use App\Traits\ApiResponseTrait;
use Illuminate\Support\Facades\Auth;

class ProfilePageController extends Controller
{
    use ApiResponseTrait;
    protected $profilePageService;

    public function __construct(ProfilePageService $profilePageService)
    {
        $this->profilePageService = $profilePageService;
    }
    public function getProfilePage($id=null){
        try {
            if(!$id){
                $id = Auth::guard('Freelancer')->user()->id;
            }
            $information = $this->profilePageService->ProfilePage($id);
            return $this->success('get Profile Page',$information);
        }
        catch (\throwable $throwable){
            return $this->serverError($throwable->getMessage());
        }
    }
    public function updateProfile(ProfileUpdateRequest $request){
        try {
            $data=$request->validated();
            $id = Auth::guard('Freelancer')->user()->id;
            $this->profilePageService->updateProfile($id,$data);
            return $this->success('Update Profile');
        }
        catch (\throwable $throwable){
            return $this->serverError($throwable->getMessage());
        }
    }

}
