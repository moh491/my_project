<?php

namespace Database\Seeders;

use App\Models\Review;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Review::truncate();
        Review::create([
            'professionalism' => 4,
        'communication' => 5,
        'quality' => 3,
        'commit_to_deadlines' => 3,
        're_employee' => 4,
        'experience'=>3,
        'description' =>'description',
            'project_id'=>1,

        ]);
        Review::create([
            'professionalism' => 4,
            'communication' => 5,
            'quality' => 3,
            'commit_to_deadlines' => 3,
            're_employee' => 2,
            'experience'=>3,
            'description' =>'description',
            'project_id'=>2,

        ]);
        Review::create([
            'professionalism' => 4,
            'communication' => 5,
            'quality' => 2,
            'commit_to_deadlines' => 3,
            're_employee' => 2,
            'experience'=>3,
            'description' =>'description',
            'project_id'=>3,

        ]);
        Review::create([
            'professionalism' => 4,
            'communication' => 5,
            'quality' => 2,
            'commit_to_deadlines' => 3,
            're_employee' => 4,
            'experience'=>3,
            'description' =>'description',
            'project_id'=>4,

        ]);
    }
}
