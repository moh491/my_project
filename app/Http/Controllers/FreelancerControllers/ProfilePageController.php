<?php

namespace App\Http\Controllers\FreelancerControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\ProfilePageService;
use App\Traits\ApiResponseTrait;

class ProfilePageController extends Controller
{
    use ApiResponseTrait;
    public function getProfilePage(string $id,ProfilePageService $profilePageService){
        try {
            $information = $profilePageService->ProfilePage($id);
            return $this->success('get Profile Page',$information);
        }
        catch (\throwable $throwable){
            return $this->serverError($throwable->getMessage());
        }
    }
    public function updateProfile(string $id,Request $request,ProfilePageService $profilePageService){
        try {
            $data=$request->all();
            $profilePageService->updateProfile($id,$data);
            return $this->success('Update Profile');
        }
        catch (\throwable $throwable){
            return $this->serverError($throwable->getMessage());
        }
    }

}
