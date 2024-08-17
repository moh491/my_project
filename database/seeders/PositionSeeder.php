<?php

namespace Database\Seeders;

use App\Models\Position;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Position::truncate();
        $positions = [
            ['name' => 'Senior Developer', 'field_id' => 1],
            ['name' => 'Junior Developer', 'field_id' => 1],
            ['name' => 'Mobile App Developer', 'field_id' => 3],
            ['name' => 'Data Analyst', 'field_id' => 5],
            ['name' => 'System Administrator', 'field_id' => 6],
            ['name' => 'UX Designer', 'field_id' => 7],
            ['name' => 'Database Engineer', 'field_id' => 8],
            ['name' => 'QA Tester', 'field_id' => 14],
            ['name' => 'ServiceMail Coordinator', 'field_id' => 15],
            ['name' => 'Product Specialist', 'field_id' => 16],
            ['name' => 'Web Developer', 'field_id' => 1],
            ['name' => 'Technical Support Engineer', 'field_id' => 19],
            ['name' => 'Network Administrator', 'field_id' => 20],
            ['name' => 'Game Designer', 'field_id' => 21],
        ];

        DB::table('positions')->insert($positions);

         DB::statement('SET FOREIGN_KEY_CHECKS=1;');
     }
}
