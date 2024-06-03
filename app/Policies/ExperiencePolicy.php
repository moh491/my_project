<?php

namespace App\Policies;

use App\Models\Experience;
use App\Models\Freelancer;
use App\Models\User;

class ExperiencePolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }
    public function access(Freelancer $freelancer, Experience $experience)
    {
        return $freelancer->id === $experience->freelancer_id;
    }


}
