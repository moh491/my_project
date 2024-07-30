<?php

namespace App\Services;

use App\Http\Resources\ProfilePageResource;
use App\Http\Resources\ProfilePageTeamResource;
use App\Models\Freelancer;
use App\Models\Team;

class ProfilePageTeamService
{
    public function ProfilePage($id)
    {
        $team = Team::find($id);
        return new ProfilePageTeamResource($team);


    }

}
