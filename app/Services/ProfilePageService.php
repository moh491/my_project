<?php

namespace App\Services;

use App\Http\Resources\PortfolioResource;
use App\Http\Resources\ProfilePageResource;
use App\Models\Freelancer;

class ProfilePageService
{
    public function ProfilePage(string $id){
        $freelancer=Freelancer::find($id);
        return new ProfilePageResource($freelancer);
    }
    public function updateProfile(string $id,$data){
        $freelancer=Freelancer::find($id);
        $freelancer->update($data);
    }
}
