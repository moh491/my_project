<?php

namespace App\Policies;

use App\Models\Education;
use App\Models\Freelancer;
use App\Models\User;

class EducationPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }
    public function update(Freelancer $freelancer, Education $education)
    {
        return $freelancer->id === $education->freelancer_id;
    }

    public function delete(Freelancer $freelancer, Education $education)
    {
        return $freelancer->id === $education->freelancer_id;
    }

}
