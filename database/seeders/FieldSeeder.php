<?php

namespace Database\Seeders;

use App\Models\Field;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FieldSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Field::truncate();
        Field::create([
            'name'=>'Web Development'
        ]);
        Field::create([
            'name'=>'Mobile App Development'
        ]);
        Field::create([
            'name'=>'Data Science and Analytics'
        ]);
    }
}
