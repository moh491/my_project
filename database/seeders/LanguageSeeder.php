<?php

namespace Database\Seeders;

use App\Models\Language;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Language::truncate();
        Language::create([
            'language'=>'en',
            'level'=>1,
            'freelancer_id'=>1

        ]);
        Language::create([
            'language'=>'ar',
            'level'=>3,
            'freelancer_id'=>1

        ]);
    }
}
