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
            'language'=>'English',
            'level'=>1,
            'freelancer_id'=>1

        ]);
        Language::create([
            'language'=>'Arabic',
            'level'=>3,
            'freelancer_id'=>1

        ]);
    }
}
