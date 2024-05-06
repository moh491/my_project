<?php

namespace Database\Seeders;

use App\Models\Position;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Position::truncate();
        Position::create([
            'name'=>'Front-end development',
            'field_id'=>1
        ]);
        Position::create([
            'name'=>'Back-end development',
            'field_id'=>1
        ]);
        Position::create([
            'name'=>'Full-stack development:',
            'field_id'=>1
        ]);
        Position::create([
            'name'=>'iOS development',
            'field_id'=>2
        ]);
        Position::create([
            'name'=>'Android development',
            'field_id'=>2
        ]);
        Position::create([
            'name'=>'Data analysis',
            'field_id'=>3
        ]);

    }
}
