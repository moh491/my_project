<?php

namespace Database\Seeders;

use App\Models\Freelancer;
use App\Models\Plan;
use App\Models\Project_Owners;
use App\Models\Service;
use App\Models\Skill;
use App\Models\Skillable_Skill;
use Illuminate\Database\Seeder;
 use Illuminate\Support\Facades\DB;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('services')->truncate();
        DB::table('plans')->truncate();
        //DB::table('skills')->truncate();
        //DB::table('skillable_skills')->truncate();

        $skillsData = [
            'full_stack_developer' => ['Laravel', 'Vue', 'Node.js'],
            'graphic_designer' => ['Photoshop', 'Illustrator', 'UI/UX'],
            'data_scientist' => ['Python', 'R', 'Big Data'],
            'digital_marketing' => ['SEO', 'Google Analytics', 'Content Marketing'],
            'mobile_app_developer' => ['Flutter', 'React Native', 'Swift'],
            'ux_ui_designer' => ['Wireframing', 'Prototyping', 'User Research'],
            'network_engineer' => ['Networking', 'Cybersecurity', 'Linux'],
            'software_tester' => ['Test Automation', 'Manual Testing', 'QA'],
            'web_developer' => ['JavaScript', 'HTML/CSS', 'React'],
            'software_engineer' => ['Java', 'C++', 'Microservices'],
        ];

        $freelancerTitles = [
            'Experienced Full Stack Developer',
            'Creative Graphic Designer',
            'Professional Data Scientist',
            'Expert in Digital Marketing',
            'Skilled Mobile App Developer',
            'Talented UX/UI Designer',
            'Dedicated Network Engineer',
            'Proficient Software Tester',
            'Passionate Web Developer',
            'Innovative Software Engineer'
        ];

        $freelancerDescriptions = [
            'Experienced Full Stack Developer with a strong background in web development.',
            'Creative Graphic Designer with over 10 years of experience.',
            'Professional Data Scientist with a passion for big data analytics.',
            'Expert in digital marketing and SEO strategies.',
            'Skilled Mobile App Developer with expertise in both iOS and Android.',
            'Talented UX/UI Designer focused on creating intuitive user experiences.',
            'Dedicated Network Engineer with extensive knowledge in network security.',
            'Proficient Software Tester with a keen eye for detail and quality.',
            'Passionate Web Developer specializing in front-end technologies.',
            'Innovative Software Engineer with a focus on scalable applications.'
        ];

        $ownerTitles = [
            'مدير مشاريع ذو خبرة',
            'رائد أعمال ماهر',
            'قائد فرق متعددة التخصصات',
            'خبير في إدارة المشاريع',
            'مدير مشاريع فعال',
            'خبير في إدارة المخاطر',
            'قائد فرق كبيرة',
            'مكرس لتحسين العمليات',
            'مفكر استراتيجي',
            'خبير في إدارة المساهمين'
        ];

        $ownerDescriptions = [
            'مدير مشاريع ذو خبرة واسعة في إدارة المشاريع المعقدة.',
            'رائد أعمال ماهر لديه خلفية في الشركات الناشئة والتكنولوجيا.',
            'شغوف بقيادة الفرق متعددة التخصصات لتحقيق الأهداف الاستراتيجية.',
            'ذو خبرة في منهجيات إدارة المشاريع الرشيقة والشلال.',
            'سجل حافل في تسليم المشاريع في الوقت المحدد وضمن الميزانية.',
            'خبير في إدارة المخاطر واستراتيجيات التخفيف.',
            'مهارات قيادة قوية مع خبرة في إدارة الفرق الكبيرة.',
            'مكرس لتحسين العمليات وتحسين سير العمل في المشاريع.',
            'مفكر استراتيجي لديه قدرة على حل تحديات المشاريع المعقدة.',
            'ماهر في إدارة المساهمين والحفاظ على علاقات قوية مع العملاء.'
        ];

        $freelancers = Freelancer::all();

        foreach ($freelancers as $index => $freelancer) {
            $title = $freelancerTitles[$index % count($freelancerTitles)];
            $description = $freelancerDescriptions[$index % count($freelancerDescriptions)];

            $service = Service::create([
                'title' => $title,
                'description' => $description,
                'image' => 'service',
                'owner_type' => 'App\\Models\\Freelancer',
                'owner_id' => $freelancer->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $this->createPlans($service->id);
            $this->attachSkills($service, $this->getRelevantSkills($title, $skillsData));
        }

        $owners = Project_Owners::all();

        foreach ($freelancers as $index => $freelancer) {
            $title = $freelancerTitles[$index % count($freelancerTitles)];
            $description = $freelancerDescriptions[$index % count($freelancerDescriptions)];

            $service = Service::create([
                'title' => $title,
                'description' => $description,
                'image' => 'service',
                'owner_type' => 'App\\Models\\Team',
                'owner_id' => $freelancer->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $this->createPlans($service->id);
            $this->attachSkills($service, $this->getRelevantSkills($title, $skillsData));
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }

    private function createPlans($serviceId)
    {
        $plans = [
            [
                'type' => 'Basic',
                'price' => 45,
                'description' => 'Our Basic Plan is ideal for startups and small businesses looking to develop a straightforward, functional mobile app.',
            ],
            [
                'type' => 'Standard',
                'price' => 75,
                'description' => 'Our Standard Plan offers additional features and customization options for businesses aiming for growth.',
            ],
            [
                'type' => 'Premium',
                'price' => 120,
                'description' => 'Our Premium Plan provides comprehensive solutions for large enterprises seeking advanced functionalities and support.',
            ],
        ];

        foreach ($plans as $plan) {
            Plan::create([
                'type' => $plan['type'],
                'price' => $plan['price'],
                'description' => $plan['description'],
                'service_id' => $serviceId,
            ]);
        }
    }

    private function attachSkills($service, $skills)
    {
        foreach ($skills as $skillName) {
            $skill = Skill::where('name', $skillName)->first();
            if ($skill) {
                Skillable_Skill::create([
                    'skill_id' => $skill->id,
                    'skillable_type' => 'App\\Models\\Service',
                    'skillable_id' => $service->id,
                ]);
            }
        }
    }

    private function getRelevantSkills($title, $skillsData)
    {
        foreach ($skillsData as $key => $skills) {
            if (stripos($title, str_replace('_', ' ', $key)) !== false) {
                return $skills;
            }
        }
        return [];
//        ServiceMail::truncate();
//        ServiceMail::create([
//            'title'=>'Mobile App Development',
//            'description'=>'Build native or cross-platform mobile applications for iOS and Android platforms. From concept to launch, we create engaging and user-friendly mobile apps that drive business growth.',
//            'owner_type'=>'App\\Models\\Freelancer',
//            'owner_id'=>'1',
//            'image'=>'service/1',
//            'preview'=>'service/1/photo_1_2024-06-02_14-03-04.jpg'
//
//        ]);
//        ServiceMail::create([
//            'title'=>'Custom Web Application Development',
//            'description'=>'We specialize in developing custom web applications tailored to meet your specific business needs. Our team will work closely with you to understand requirements, design, develop, and deploy scalable web solutions.',
//            'owner_type'=>'App\\Models\\Freelancer',
//            'owner_id'=>'1',
//            'image'=>'service/1',
//            'preview'=>'service/1/photo_1_2024-06-02_14-03-04.jpg'
//        ]);
//        ServiceMail::create([
//            'title'=>'UI/UX Design Services',
//            'description'=>'Create intuitive and visually appealing user interfaces (UI) and user experiences (UX) that enhance usability and drive customer engagement.',
//            'owner_type'=>'App\\Models\\Freelancer',
//            'owner_id'=>'1',
//            'image'=>'service/1',
//            'preview'=>'service/1/photo_1_2024-06-02_14-03-04.jpg'
//        ]);
//        ServiceMail::create([
//            'title'=>'API Development and Integration',
//            'description'=>'Design and implement robust APIs to enable seamless communication and integration between different systems and services.',
//            'owner_type'=>'App\\Models\\Freelancer',
//            'owner_id'=>'1',
//            'image'=>'service/1',
//            'preview'=>'service/1/photo_1_2024-06-02_14-03-04.jpg'
//        ]);
//        ServiceMail::create([
//            'title'=>'Data Analytics and Visualization',
//            'description'=>'Utilize data analytics tools and techniques to derive actionable insights from complex data sets and create interactive visualizations for informed decision-making.',
//            'owner_type'=>'App\\Models\\Freelancer',
//            'owner_id'=>'1',
//            'image'=>'service/1',
//            'preview'=>'service/1/photo_1_2024-06-02_14-03-04.jpg'
//        ]);
//        ServiceMail::create([
//            'title'=>'DevOps and Continuous Integration/Delivery',
//            'description'=>'Implement DevOps practices to automate software development, testing, and deployment processes, ensuring faster delivery and improved collaboration.',
//            'owner_type'=>'App\\Models\\Freelancer',
//            'owner_id'=>'1',
//            'image'=>'service/1',
//            'preview'=>'service/1/photo_1_2024-06-02_14-03-04.jpg'
//        ]);
    }
}
