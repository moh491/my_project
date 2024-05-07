<?php

namespace App\Services;

use App\Models\Skill;

class SkillService
{
    public function create(string $id,array $skills)
    {
        foreach ($skills as $skill) {
            $skill = Skill::create([
                'name' => $skill,
            ]);
            $skill->freelancers()->attach($id);
        }
    }
    public function delete(string $id){
        Skill::where('id',$id)->delete();
    }

}
