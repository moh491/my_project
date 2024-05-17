<?php

namespace App\Http\Controllers\FreelancerControllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\ProfilePageService;
use App\Traits\ApiResponseTrait;
use Illuminate\Support\Facades\Auth;

class ProfilePageController extends Controller
{
    use ApiResponseTrait;
    public function getProfilePage(ProfilePageService $profilePageService,$id=null){
        try {
            if(!$id){
                $id = Auth::user()->id;
            }
            $information = $profilePageService->ProfilePage($id);
            return $this->success('get Profile Page',$information);
        }
        catch (\throwable $throwable){
            return $this->serverError($throwable->getMessage());
        }
    }
    public function updateProfile(Request $request,ProfilePageService $profilePageService){
        try {
            $data=$request->all();
            $id =Auth::user()->id;
            $profilePageService->updateProfile($id,$data);
            return $this->success('Update Profile');
        }
        catch (\throwable $throwable){
            return $this->serverError($throwable->getMessage());
        }
    }

}
