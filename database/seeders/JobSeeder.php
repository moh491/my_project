<?php

namespace Database\Seeders;

use App\Models\CompanyJob;
use Illuminate\Database\Seeder;

class JobSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $array = [
            "Proven experience as a Front-end Developer or similar role",
            'Strong proficiency in HTML, CSS, and JavaScript',
            'Experience with front-end frameworks and libraries (e.g., React, Angular, Vue.js)',
            'Familiarity with RESTful APIs and asynchronous request handling',
            'Solid understanding of responsive design principles and mobile-first approach',
            'Experience with version control systems (e.g., GitExcellent problem-solving skills and attention to data'
        ];
        CompanyJob::truncate();
        CompanyJob::create([
            'title' => "Backend Developer",
            'location_type' => 1,
            'employment_type' => 1,
            'level' => 1,
            'description' => 'We are looking for a skilled Front-end Developer to join our creative team As a Front-end Developer you will be responsible for implementing visua interactive elements that users engage with through web browsers You will work closely with designers and back-end developers to deliver high-quality responsive web applications',
            'min_salary' => '1000',
            'max_salary' => '3000',
            'responsibilities' => json_encode($array),
            'position_id' => 1,
            'company_id' => 1,
        ]);
        CompanyJob::create([
            'title' => "UI/UX Designer",
            'location_type' => 2,
            'employment_type' => 2,
            'level' => 2,
            'description' => 'We are seeking a talented Back-end Developer to join our growing team. As a Back-end Developer, you will be responsible for designing, developing, and maintaining server-side logic and databases for our web applications. You will work closely with front-end developers, UI/UX designers, and stakeholders to deliver scalable and efficient solutions',
            'min_salary' => '1000',
            'max_salary' => '3000',
            'responsibilities' => json_encode($array),
            'position_id' => 2,
            'company_id' => 1,
        ]);
        CompanyJob::create([
            'title' => "UI/UX Designer",
            'location_type' => 2,
            'employment_type' => 2,
            'level' => 2,
            'description' => 'We are seeking a versatile Full-stack Developer to join our development team. As a Full-stack Developer, you will be responsible for designing, developing, and maintaining web applications across the entire stack. You will work on both front-end and back-end technologies to deliver scalable and responsive solutions',
            'min_salary' => '1000',
            'max_salary' => '3000',
            'responsibilities' => json_encode($array),
            'position_id' => 3,
            'company_id' => 1,
        ]);


    }
}
