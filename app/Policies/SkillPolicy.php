<?php

namespace App\Policies;

use App\Models\Freelancer;
use App\Models\Team;
use App\Models\User;

class SkillPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }
    public function isMemberOfTeam(Freelancer $freelancer,Team $team){
        return $team->freelancers->contains($freelancer->id);
    }
}
