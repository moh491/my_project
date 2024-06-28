<?php

namespace Database\Seeders;

use App\Models\Application;
use App\Models\Freelancer;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;


class FreelancerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        Freelancer::truncate();
        Freelancer::create([
            'first_name'=>'Loujain',
            'last_name'=>'Diab',
            'email'=>'loujaindiab551@gmail.com',
            'email_verified_at'=>'2023-06-11 19:25:02',
            'password'=>bcrypt('123456789'),
            'position_id'=>1,
            'about'=>'The description of the freelancer',
            'location'=>'Damascus, Syria',
            'profile'=>'freelancer-profile/OIP (1).jpg',
            'time_zone'=>'EET UTC+3',
        ]);
        Freelancer::create([
            'first_name'=>'Sara',
            'last_name'=>'Mak',
            'email'=>'sara@gmail.com',
            'email_verified_at'=>'2023-06-11 19:25:02',
            'password'=>bcrypt('123456789'),
            'position_id'=>2,
            'about'=>'The description of the freelancer',
            'location'=>'Damascus, Syria',
            'profile'=>'freelancer-profile/OIP (1).jpg',
            'time_zone'=>'EET UTC+3',
        ]);

    }
}
