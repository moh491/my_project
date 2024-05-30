<?php

namespace Database\Seeders;

use App\Models\Project;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Project::truncate();
        Project::create([
            'title'=>'Online Clothing Store',
            'description'=>'Built an e-commerce website for a clothing store using React.js and Django. Integrated payment gateway for online transactions, implemented product catalog with filtering and sorting functionalities, and optimized performance for a seamless shopping experience.',
            'min_budget'=>1000,
            'max_budget'=>2000,
            'status'=>4,
            'project_owner_id'=>1,
            'field_id'=>3,
            'worker_type'=>'App\\Models\\Freelancer',
            'worker_id'=>1,
        ]);


    }
}
