<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Service::truncate();
        Service::create([
            'title'=>'Mobile App Development',
            'description'=>'Build native or cross-platform mobile applications for iOS and Android platforms. From concept to launch, we create engaging and user-friendly mobile apps that drive business growth.',
            'owner_type'=>'App\\Models\\Freelancer',
            'owner_id'=>'1',
            'image'=>'service/1',
            'preview'=>'service/1/photo_1_2024-06-02_14-03-04.jpg'

        ]);
        Service::create([
            'title'=>'Custom Web Application Development',
            'description'=>'We specialize in developing custom web applications tailored to meet your specific business needs. Our team will work closely with you to understand requirements, design, develop, and deploy scalable web solutions.',
            'owner_type'=>'App\\Models\\Freelancer',
            'owner_id'=>'1',
            'image'=>'service/1',
            'preview'=>'service/1/photo_1_2024-06-02_14-03-04.jpg'
        ]);
        Service::create([
            'title'=>'UI/UX Design Services',
            'description'=>'Create intuitive and visually appealing user interfaces (UI) and user experiences (UX) that enhance usability and drive customer engagement.',
            'owner_type'=>'App\\Models\\Freelancer',
            'owner_id'=>'1',
            'image'=>'service/1',
            'preview'=>'service/1/photo_1_2024-06-02_14-03-04.jpg'
        ]);
        Service::create([
            'title'=>'API Development and Integration',
            'description'=>'Design and implement robust APIs to enable seamless communication and integration between different systems and services.',
            'owner_type'=>'App\\Models\\Freelancer',
            'owner_id'=>'1',
            'image'=>'service/1',
            'preview'=>'service/1/photo_1_2024-06-02_14-03-04.jpg'
        ]);
        Service::create([
            'title'=>'Data Analytics and Visualization',
            'description'=>'Utilize data analytics tools and techniques to derive actionable insights from complex data sets and create interactive visualizations for informed decision-making.',
            'owner_type'=>'App\\Models\\Freelancer',
            'owner_id'=>'1',
            'image'=>'service/1',
            'preview'=>'service/1/photo_1_2024-06-02_14-03-04.jpg'
        ]);
        Service::create([
            'title'=>'DevOps and Continuous Integration/Delivery',
            'description'=>'Implement DevOps practices to automate software development, testing, and deployment processes, ensuring faster delivery and improved collaboration.',
            'owner_type'=>'App\\Models\\Freelancer',
            'owner_id'=>'1',
            'image'=>'service/1',
            'preview'=>'service/1/photo_1_2024-06-02_14-03-04.jpg'
        ]);
    }
}
