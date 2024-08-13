<?php

namespace Database\Seeders;

use App\Enums\Languages_status;
use App\Models\Language;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('languages')->truncate();

        $freelancers = DB::table('freelancers')->get();

        $languages = [
            'en' => [
                ['language' => 'German', 'level' => Languages_status::NATIVE],
                ['language' => 'English', 'level' => Languages_status::FLUENT],
                ['language' => 'English', 'level' => Languages_status::FLUENT],
                ['language' => 'French', 'level' => Languages_status::NATIVE],
                ['language' => 'English', 'level' => Languages_status::FLUENT],
                ['language' => 'Spanish', 'level' => Languages_status::NATIVE],
                ['language' => 'English', 'level' => Languages_status::FLUENT],
                ['language' => 'Italian', 'level' => Languages_status::NATIVE],
                ['language' => 'English', 'level' => Languages_status::FLUENT],
                ['language' => 'Dutch', 'level' => Languages_status::NATIVE],
                ['language' => 'English', 'level' => Languages_status::FLUENT],
                ['language' => 'Austrian German', 'level' => Languages_status::NATIVE],
                ['language' => 'English', 'level' => Languages_status::FLUENT],
                ['language' => 'Swiss German', 'level' => Languages_status::NATIVE],
                ['language' => 'English', 'level' => Languages_status::FLUENT],
                ['language' => 'Swedish', 'level' => Languages_status::NATIVE],
                ['language' => 'English', 'level' => Languages_status::FLUENT],
                ['language' => 'Danish', 'level' => Languages_status::NATIVE],
                ['language' => 'English', 'level' => Languages_status::FLUENT],
            ],
            'ar' => [
                ['language' => 'Arabic', 'level' => Languages_status::NATIVE],
                ['language' => 'English', 'level' => Languages_status::FLUENT],
                ['language' => 'Arabic', 'level' => Languages_status::NATIVE],
                ['language' => 'English', 'level' => Languages_status::FLUENT],
                ['language' => 'Arabic', 'level' => Languages_status::NATIVE],
                ['language' => 'English', 'level' => Languages_status::FLUENT],
                ['language' => 'Arabic', 'level' => Languages_status::NATIVE],
                ['language' => 'English', 'level' => Languages_status::FLUENT],
                ['language' => 'Arabic', 'level' => Languages_status::NATIVE],
                ['language' => 'English', 'level' => Languages_status::FLUENT],
                ['language' => 'Arabic', 'level' => Languages_status::NATIVE],
                ['language' => 'English', 'level' => Languages_status::FLUENT],
                ['language' => 'Arabic', 'level' => Languages_status::NATIVE],
                ['language' => 'English', 'level' => Languages_status::FLUENT],
                ['language' => 'Arabic', 'level' => Languages_status::NATIVE],
                ['language' => 'English', 'level' => Languages_status::FLUENT],
                ['language' => 'Arabic', 'level' => Languages_status::NATIVE],
                ['language' => 'English', 'level' => Languages_status::FLUENT],
                ['language' => 'Arabic', 'level' => Languages_status::NATIVE],
                ['language' => 'English', 'level' => Languages_status::FLUENT]
            ]
        ];

        for ($i = 0; $i < 10; $i++) {
            if (isset($languages['en'][$i * 2])) {
                DB::table('languages')->insert([
                    'language' => $languages['en'][$i * 2]['language'],
                    'level' => $languages['en'][$i * 2]['level'],
                    'freelancer_id' => $freelancers[$i]->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            if (isset($languages['en'][$i * 2 + 1])) {
                DB::table('languages')->insert([
                    'language' => $languages['en'][$i * 2 + 1]['language'],
                    'level' => $languages['en'][$i * 2 + 1]['level'],
                    'freelancer_id' => $freelancers[$i]->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        for ($i = 0; $i < 10; $i++) {
            if (isset($languages['ar'][$i * 2])) {
                DB::table('languages')->insert([
                    'language' => $languages['ar'][$i * 2]['language'],
                    'level' => $languages['ar'][$i * 2]['level'],
                    'freelancer_id' => $freelancers[$i + 10]->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            if (isset($languages['ar'][$i * 2 + 1])) {
                DB::table('languages')->insert([
                    'language' => $languages['ar'][$i * 2 + 1]['language'],
                    'level' => $languages['ar'][$i * 2 + 1]['level'],
                    'freelancer_id' => $freelancers[$i + 10]->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
//        Language::create([
//            'language'=>'English',
//            'level'=>1,
//            'freelancer_id'=>1
//
//        ]);
//        Language::create([
//            'language'=>'Arabic',
//            'level'=>3,
//            'freelancer_id'=>1
//        ]);

    }
}
