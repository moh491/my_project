<?php

namespace Database\Seeders;


use App\Models\Project_Owners;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProjectOwnerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Project_Owners::truncate();
        Project_Owners::create([
            'first_name'=>'Loujain',
            'last_name'=>'Diab',
            'email'=>'loujain@gmail.com',
            'email_verified_at'=>'2023-06-11 19:25:02',
            'password'=>'1245667',
            'about'=>'The description of the project owner',
            'location'=>'Damascus, Syria',
            'time_zone'=>'EET UTC+3'
        ]);
        Project_Owners::create([
            'first_name'=>'Huda',
            'last_name'=>'Shaker',
            'email_verified_at'=>'2023-06-11 19:25:02',
            'email'=>'Huda@gmail.com',
            'password'=>'1245667',
            'about'=>'The description of the project owner',
            'location'=>'Damascus, Syria',
            'time_zone'=>'EET UTC+3'
        ]);
        Project_Owners::create([
            'first_name'=>'Sara',
            'last_name'=>'Mak',
            'email'=>'Sara@gmail.com',
            'email_verified_at'=>'2023-06-11 19:25:02',
            'password'=>'1245667',
            'about'=>'The description of the project owner',
            'location'=>'Damascus, Syria',
            'time_zone'=>'EET UTC+3'
        ]);
    }
}
