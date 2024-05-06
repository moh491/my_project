<?php

namespace Database\Seeders;

use App\Models\Education;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EducationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Education::truncate();
        Education::create([
        'title'=>'Advanced Diploma In Multimedia',
        'institution'=>'Damascus UnUniversity',
            'start_year'=>'2024-05-01',
            'end_year'=>'2027-05-01',
        'average'=>70,
        'description'=>'The Advanced Diploma in Multimedia program offers a blend of theoretical knowledge and hands-on practical training, preparing students for careers in digital media, interactive design, animation, and visual communication. The curriculum is carefully crafted to cover a wide range of topics essential for success in the multimedia industry.',
        'freelancer_id'=>1,
            'location'=>'Damascus, Syria'
    ]);
        Education::create([
            'title'=>'Advanced Diploma In Algorithm',
            'institution'=>'Damascus UnUniversity',
            'location'=>'Damascus, Syria',
            'start_year'=>'2024-05-01',
            'end_year'=>'2027-05-01',
            'average'=>60,
            'description'=>'The Advanced Diploma in Algorithm program is designed to provide students with advanced theoretical knowledge and practical skills in algorithm development, optimization, and analysis. Students explore complex algorithms used in software development, artificial intelligence, data science, and computational biology.',
            'freelancer_id'=>1,
        ]);


    }
}
