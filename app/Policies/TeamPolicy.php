<?php

namespace App\Policies;

use App\Models\Freelancer;
use App\Models\Team;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TeamPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    use HandlesAuthorization;

    public function view(Freelancer $freelancer, Team $team)
    {
        return $freelancer->teams()->where('team_id', $team->id)->exists();
    }

    public function create(Freelancer $freelancer)
    {
        return true;
    }

    public function update(Freelancer $freelancer, Team $team)
    {
//        return $team->freelancers()
//            ->where('freelancer_id', $user->id)
//            ->wherePivot('is_owner', true)
//            ->exists();
        return $freelancer->teams()->where('team_id', $team->id)->exists();
    }

    public function addMember(Freelancer $freelancer, Team $team)
    {
        return $freelancer->teams()->where('team_id', $team->id)->exists();
    }

    public function removeMember(Freelancer $freelancer, Team $team)
    {
        return $freelancer->teams()->where('team_id', $team->id)->exists();
    }

    public function delete(Freelancer $freelancer, Team $team)
    {
         return $freelancer->teams()
            ->where('team_id', $team->id)
            ->wherePivot('is_owner', true)
            ->exists();
    }

//    public function delete(Freelancer $freelancer, Team $team)
//    {
//        return $freelancer->teams()->where('team_id', $team->id)->exists();
//    }
}
