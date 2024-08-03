<?php

namespace Database\Seeders;

use App\Models\Freelancer_Team;
use App\Models\Team;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TeamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Team::truncate();
        Team::create([
            'name'=>'team 1',
            'about'=>'this  is team 1 ',
            'link'=>'link',
            'logo'=>'logo',
            'withdrawal_balance'=>'200',
            'available_balance'=>'500',
            'suspended_balance'=>'50',

            ]);
        Freelancer_Team::create([
            'freelancer_id'=>1,
            'team_id'=>1,
            'position_id'=>1
        ]);
        Freelancer_Team::create([
            'freelancer_id'=>2,
            'team_id'=>1,
            'position_id'=>1
        ]);
    }
}
