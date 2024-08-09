<?php

namespace Database\Seeders;

use App\Models\Freelancer;
use App\Models\Freelancer_Team;
use App\Models\Skill;
use App\Models\Skillable_Skill;
use App\Models\Team;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TeamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('teams')->truncate();
        DB::table('freelancer__teams')->truncate();

        $teams = [
            [
                'name' => 'Web Development Wizards',
                'logo' => 'team-logo/web-development.jpg',
                'link' => 'https://webdevelopmentwizards.com',
                'about' => 'A team of expert developers specializing in full stack web development, creating responsive and high-performance websites and web applications.',
                'position_ids' => [1, 9, 10],
                'skills' => ['laravel', 'Vue'],
            ],
            [
                'name' => 'Creative Designers Hub',
                'logo' => 'team-logo/creative-designers.jpg',
                'link' => 'https://creativedesignershub.com',
                'about' => 'A group of talented designers focusing on creating innovative and visually appealing designs for branding, websites, and mobile apps.',
                'position_ids' => [2, 6],
                'skills' => ['Photoshop', 'Illustrator'],
            ],
            [
                'name' => 'Data Science Innovators',
                'logo' => 'team-logo/data-science.jpg',
                'link' => 'https://datascienceinnovators.com',
                'about' => 'This team excels in big data analytics, machine learning, and AI, delivering insightful solutions for complex data challenges.',
                'position_ids' => [4, 10],
                'skills' => ['Python', 'R', 'TensorFlow'],
            ],
            [
                'name' => 'Mobile App Masters',
                'logo' => 'team-logo/mobile-apps.jpg',
                'link' => 'https://mobileappmasters.com',
                'about' => 'Specializing in mobile app development for both iOS and Android platforms, this team delivers high-quality, user-friendly mobile experiences.',
                'position_ids' => [3, 5],
                'skills' => ['Flutter', 'React Native'],
            ],
            [
                'name' => 'Digital Marketing Gurus',
                'logo' => 'team-logo/digital-marketing.jpg',
                'link' => 'https://digitalmarketinggurus.com',
                'about' => 'A team of digital marketing experts providing services in SEO, social media marketing, and online advertising to boost business visibility.',
                'position_ids' => [7, 8],
                'skills' => ['SEO', 'Google Analytics', 'Social Media Marketing'],
            ],
        ];

        foreach ($teams as $teamData) {
            $team = Team::create([
                'name' => $teamData['name'],
                'logo' => $teamData['logo'],
                'link' => $teamData['link'],
                'about' => $teamData['about'],
                'withdrawal_balance' => rand(100, 500),
                'available_balance' => rand(400, 2000),
                'suspended_balance' => rand(0, 100),
            ]);

            $freelancers = Freelancer::whereIn('position_id', $teamData['position_ids'])->limit(4)->get();

            foreach ($freelancers as $index => $freelancer) {
                Freelancer_Team::create([
                    'freelancer_id' => $freelancer->id,
                    'team_id' => $team->id,
                    'position_id' => $freelancer->position_id,
                    'is_owner' => $index == 0 ? true : false,
                ]);
            }

            foreach ($teamData['skills'] as $skillName) {
                $skill = Skill::firstOrCreate(['name' => $skillName]);

                Skillable_Skill::create([
                    'skill_id' => $skill->id,
                    'skillable_type' => 'App\\Models\\Team',
                    'skillable_id' => $team->id,
                ]);
            }
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');



//        Team::create([
//            'name'=>'team 1',
//            'about'=>'this  is team 1 ',
//            'link'=>'link',
//            'logo'=>'logo',
//            'withdrawal_balance'=>'200',
//            'available_balance'=>'500',
//            'suspended_balance'=>'50',
//
//            ]);
//        Freelancer_Team::create([
//            'freelancer_id'=>1,
//            'team_id'=>1,
//            'position_id'=>1
//        ]);
//        Freelancer_Team::create([
//            'freelancer_id'=>2,
//            'team_id'=>1,
//            'position_id'=>1
//        ]);
    }
}
