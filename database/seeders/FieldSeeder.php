<?php

namespace Database\Seeders;

use App\Models\Field;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FieldSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('fields')->truncate();

        $fields = [
            ['name' => 'Full Stack Developer'],
            ['name' => 'Backend Developer'],
            ['name' => 'Frontend Developer'],
            ['name' => 'Mobile Developer'],
            ['name' => 'Data Scientist'],
            ['name' => 'DevOps Engineer'],
            ['name' => 'UI/UX Designer'],
            ['name' => 'Database Administrator'],
            ['name' => 'System Analyst'],
            ['name' => 'Machine Learning Engineer'],
            ['name' => 'Cybersecurity Specialist'],
            ['name' => 'Cloud Engineer'],
            ['name' => 'Business Intelligence Analyst'],
            ['name' => 'QA Engineer'],
            ['name' => 'ServiceMail Manager'],
            ['name' => 'Product Manager'],
            ['name' => 'Web Designer'],
            ['name' => 'Technical Support Specialist'],
            ['name' => 'Network Engineer'],
            ['name' => 'Software Engineer'],
            ['name' => 'Game Developer']
        ];
        DB::table('fields')->insert($fields);
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
