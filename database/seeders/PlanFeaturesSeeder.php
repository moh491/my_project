<?php

namespace Database\Seeders;

use App\Models\Plan_Feature;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PlanFeaturesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Plan_Feature::create([
            'value'=>'4',
            'plan_id'=>1,
            'feature_id'=>1
        ]);
        Plan_Feature::create([
            'value'=>'false',
            'plan_id'=>1,
            'feature_id'=>2
        ]);


        Plan_Feature::create([
            'value'=>'6',
            'plan_id'=>2,
            'feature_id'=>1
        ]);
        Plan_Feature::create([
            'value'=>'true',
            'plan_id'=>2,
            'feature_id'=>2
        ]);



        Plan_Feature::create([
            'value'=>'unlimited',
            'plan_id'=>3,
            'feature_id'=>1
        ]);
        Plan_Feature::create([
            'value'=>'true',
            'plan_id'=>3,
            'feature_id'=>2
        ]);


    }
}
