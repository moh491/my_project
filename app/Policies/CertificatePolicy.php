<?php

namespace App\Policies;

use App\Models\Certification;
use App\Models\Freelancer;
use App\Models\User;
use App\Traits\ApiResponseTrait;

class CertificatePolicy
{
    use ApiResponseTrait;
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function access(Freelancer $freelancer, Certification $certification)
    {
        return $freelancer->id === $certification->freelancer_id;
    }

}
