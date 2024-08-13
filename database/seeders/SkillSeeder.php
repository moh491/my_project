<?php

namespace Database\Seeders;

use App\Models\Skill;
use App\Models\Skillable_Skill;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SkillSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        Skill::create([
            'name'=>'laravel',
        ]);
        Skill::create([
            'name'=>'Vue',
        ]);
        Skill::create([
            'name'=>'Flutter',
        ]);

        Skillable_Skill::create([
            'skill_id'=>1,
            'skillable_type'=> 'App\\Models\\Freelancer',
            'skillable_id'=>1,
        ]);
        Skillable_Skill::create([
            'skill_id'=>1,
            'skillable_type'=> 'App\\Models\\Project',
            'skillable_id'=>1,
        ]);
        Skillable_Skill::create([
            'skill_id'=>2,
            'skillable_type'=> 'App\\Models\\Project',
            'skillable_id'=>1,
        ]);
        Skillable_Skill::create([
            'skill_id'=>3,
            'skillable_type'=> 'App\\Models\\Project',
            'skillable_id'=>1,
        ]);
        Skillable_Skill::create([
            'skill_id'=>2,
            'skillable_type'=> 'App\\Models\\Freelancer',
            'skillable_id'=>1,
        ]);
    }
}
