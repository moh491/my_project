<?php

namespace Database\Seeders;

use App\Models\Feature;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class featuresSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Feature::create([
            'name'=>'Core Functionality',
            'is_boolean'=>false,
            'service_id'=>1,
        ]);
        Feature::create([
            'name'=>'App Concept Consultation',
            'is_boolean'=>true,
            'service_id'=>1,
        ]);

    }
}
