<?php

namespace Database\Seeders;

use App\Models\Job;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JobSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Job::truncate();
        Job::create([
            'location_type'=>1,
            'employment_type'=>1,
            'level'=>1,
            'description'=>'We are looking for a skilled Front-end Developer to join our creative team As a Front-end Developer you will be responsible for implementing visua interactive elements that users engage with through web browsers You will work closely with designers and back-end developers to deliver high-quality responsive web applications',
            'min_salary'=>'1000',
            'max_salary'=>'3000',
            'responsibilities'=>'Proven experience as a Front-end Developer or similar role,Strong proficiency in HTML, CSS, and JavaScript,Experience with front-end frameworks and libraries (e.g., React, Angular, Vue.js),Familiarity with RESTful APIs and asynchronous request handling,Solid understanding of responsive design principles and mobile-first approach,Experience with version control systems (e.g., GitExcellent problem-solving skills and attention to deta.',
            'position_id'=>1,
            'company_id'=>1,
        ]);
        Job::create([
            'location_type'=>2,
            'employment_type'=>2,
            'level'=>2,
            'description'=>'We are seeking a talented Back-end Developer to join our growing team. As a Back-end Developer, you will be responsible for designing, developing, and maintaining server-side logic and databases for our web applications. You will work closely with front-end developers, UI/UX designers, and stakeholders to deliver scalable and efficient solutions',
            'min_salary'=>'1000',
            'max_salary'=>'3000',
            'responsibilities'=>'Develop robust and scalable server-side applications ,Design and implement RESTful APIs for web and mobile applications,Optimize applications for maximum speed and scalability,Collaborate with front-end developers to integrate user-facing elements with server-side logic,Implement data storage solutions, including databases, caching mechanisms, and data replication processes,Troubleshoot and debug complex issues in a timely manner,Write clean, maintainable, and reusable code.',
            'position_id'=>2,
            'company_id'=>1,
        ]);
        Job::create([
            'location_type'=>2,
            'employment_type'=>2,
            'level'=>2,
            'description'=>'We are seeking a versatile Full-stack Developer to join our development team. As a Full-stack Developer, you will be responsible for designing, developing, and maintaining web applications across the entire stack. You will work on both front-end and back-end technologies to deliver scalable and responsive solutions',
            'min_salary'=>'1000',
            'max_salary'=>'3000',
            'responsibilities'=>'Develop and implement user interfaces using HTML, CSS, and JavaScript,sign and develop server-side applications and APIs using modern programming languages (e.g., JavaScript/Node.js, Python/Django, Ruby on Rails),Collaborate with UI/UX designers to translate wireframes and mockups into functional web pages,Implement and maintain databases (relational and non-relational) to support application development,Optimize applications for maximum speed and scalability.',
            'position_id'=>3,
            'company_id'=>1,
        ]);


    }
}
