<?php

namespace App\Policies;

use App\Models\Delivery_Option;
use App\Models\Freelancer;
use App\Models\Project_Owners;
use App\Models\Request;
use App\Models\Team;
use App\Models\User;

class RequestPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }
    public function authorized(Freelancer $freelancer, Request $request )
    {
        $delivery=Delivery_Option::find($request->delivery_option_id);
        $service=$delivery->plan->service;
        if($service->owner_type==Team::class){
            $team=Team::find($service->owner_id);
            return $this->isMemberOfTeam($freelancer,$team);
        }
        else{
            return  $service->owner_id === $freelancer->id;
        }
    }
    public function isMemberOfTeam(Freelancer $freelancer,Team $team){
        return $team->freelancers->contains($freelancer->id);
    }
    public function updateRating(Project_Owners $project_Owners, Request $request)
    {
        return $project_Owners->id === $request->project_owner_id;
    }
}
