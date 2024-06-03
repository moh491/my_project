<?php

namespace App\Policies;

use App\Models\Freelancer;
use App\Models\Service;
use App\Models\Team;
use App\Models\User;

class ServicePolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }
    public function access(Freelancer $freelancer,  Service $service)
    {
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


}
