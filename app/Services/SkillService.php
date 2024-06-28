<?php

namespace App\Services;

use App\Models\Freelancer;
use App\Models\Skill;
use Illuminate\Support\Facades\Auth;

class SkillService
{    //freelancer is a member of team
    public function create(string $id,$model,array $skills)
    {
        $user = $model::find($id);
        $user->skills()->attach($skills);
    }
    public function delete(string $skillId,$id,$model){
            $freelancer = $model::find($id);
            $freelancer->skills()->detach($skillId);
    }


}
