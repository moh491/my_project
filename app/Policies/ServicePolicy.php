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
    public function update(Freelancer $freelancer,  Service $service, ?int $teamId = null)
    {
        if (is_null($teamId)) {
            if ($service->owner_type === Freelancer::class) {
                // Check if the user is the freelancer who owns the service
                return $service->owner_id === $freelancer->id;
            }
        }
        else {
            if($service->owner_type === Team::class && $service->owner_id === $teamId){
                // Check if the user is a member of the team that owns the service
            $team = Team::find($teamId);
            return $team->freelancers->contains($freelancer->id);
            }
        }
        return false;
    }

    public function delete(Freelancer $freelancer,  Service $service, ?int $teamId = null)
    {
        if (is_null($teamId)) {
            if ($service->owner_type === Freelancer::class) {
                // Check if the user is the freelancer who owns the service
                return $service->owner_id === $freelancer->id;
            }
        }
        else {
            if($service->owner_type === Team::class && $service->owner_id === $teamId){
                // Check if the user is a member of the team that owns the service
                $team = Team::find($teamId);
                return $team->freelancers->contains($freelancer->id);
            }
        }
        return false;
    }


}
