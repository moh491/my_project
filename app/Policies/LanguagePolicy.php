<?php

namespace App\Policies;

use App\Models\Freelancer;
use App\Models\Language;
use App\Models\User;

class LanguagePolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }
    public function delete(Freelancer $freelancer, Language $language)
    {
        return $freelancer->id === $language->freelancer_id;
    }
}
