<?php

namespace Database\Seeders;

use App\Models\Owner_Portfolio;
use App\Models\Portfolio;
use App\Models\Skillable_Skill;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PortfolioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Portfolio::create([
            'title'=>'project1',
            'description'=>'Our portfolio showcases a comprehensive pharmacy management system designed to streamline operations, enhance customer service, and optimize medication management. The system comprises a Laravel backend for robust data management and a Vue.js frontend for seamless cross-platform user experiences',
            'date'=>'2024-05-01',
            'preview'=>'portfolio/1/photo_2024-06-02_13-42-53.jpg',
            'images'=>'portfolio/1',
            'demo'=>'demo',
            'link'=>'link'
        ]);
        Portfolio::create([
            'title'=>'project2',
            'description'=>'Our portfolio showcases a comprehensive pharmacy management system designed to streamline operations, enhance customer service, and optimize medication management. The system comprises a Laravel backend for robust data management and a Vue.js frontend for seamless cross-platform user experiences',
            'date'=>'2024-05-01',
            'preview'=>'portfolio/1/photo_2024-06-02_13-42-53.jpg',
            'images'=>'portfolio/1',
            'demo'=>'demo',
            'link'=>'link'
        ]);
        Owner_Portfolio::create([
            'portfolio_id'=>1,
            'owner_type'=>'App\\Models\\Freelancer',
            'owner_id'=>1,
        ]);
        Owner_Portfolio::create([
            'portfolio_id'=>1,
            'owner_type'=>'App\\Models\\Freelancer',
            'owner_id'=>2,
        ]);
        Owner_Portfolio::create([
            'portfolio_id'=>2,
            'owner_type'=>'App\\Models\\Team',
            'owner_id'=>1,
        ]);
        Skillable_Skill::create([
            'skill_id'=>1,
            'skillable_type'=> 'App\\Models\\Portfolio',
            'skillable_id'=>1,
        ]);
        Skillable_Skill::create([
            'skill_id'=>2,
            'skillable_type'=> 'App\\Models\\Portfolio',
            'skillable_id'=>1,
        ]);
    }
}
