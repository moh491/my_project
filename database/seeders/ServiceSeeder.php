<?php

namespace Database\Seeders;

use App\Models\Freelancer;
use App\Models\Project_Owners;
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

        // بيانات الـ Freelancers (باللغة الإنجليزية)
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
            DB::table('services')->insert([
                'title' => $freelancerTitles[$index % count($freelancerTitles)],
                'description' => $freelancerDescriptions[$index % count($freelancerDescriptions)],
                'image' => 'null',
                'owner_type' => 'Freelancer',
                'owner_id' => $freelancer->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // استرجاع جميع الـ Project Owners
        $owners = Project_Owners::all();

        foreach ($owners as $index => $owner) {
            DB::table('services')->insert([
                'title' => $ownerTitles[$index % count($ownerTitles)],
                'description' => $ownerDescriptions[$index % count($ownerDescriptions)],
                'image' => 'null',
                'owner_type' => 'Project_Owner',
                'owner_id' => $owner->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
//        Service::truncate();
//        Service::create([
//            'title'=>'Mobile App Development',
//            'description'=>'Build native or cross-platform mobile applications for iOS and Android platforms. From concept to launch, we create engaging and user-friendly mobile apps that drive business growth.',
//            'owner_type'=>'App\\Models\\Freelancer',
//            'owner_id'=>'1',
//            'image'=>'service/1',
//            'preview'=>'service/1/photo_1_2024-06-02_14-03-04.jpg'
//
//        ]);
//        Service::create([
//            'title'=>'Custom Web Application Development',
//            'description'=>'We specialize in developing custom web applications tailored to meet your specific business needs. Our team will work closely with you to understand requirements, design, develop, and deploy scalable web solutions.',
//            'owner_type'=>'App\\Models\\Freelancer',
//            'owner_id'=>'1',
//            'image'=>'service/1',
//            'preview'=>'service/1/photo_1_2024-06-02_14-03-04.jpg'
//        ]);
//        Service::create([
//            'title'=>'UI/UX Design Services',
//            'description'=>'Create intuitive and visually appealing user interfaces (UI) and user experiences (UX) that enhance usability and drive customer engagement.',
//            'owner_type'=>'App\\Models\\Freelancer',
//            'owner_id'=>'1',
//            'image'=>'service/1',
//            'preview'=>'service/1/photo_1_2024-06-02_14-03-04.jpg'
//        ]);
//        Service::create([
//            'title'=>'API Development and Integration',
//            'description'=>'Design and implement robust APIs to enable seamless communication and integration between different systems and services.',
//            'owner_type'=>'App\\Models\\Freelancer',
//            'owner_id'=>'1',
//            'image'=>'service/1',
//            'preview'=>'service/1/photo_1_2024-06-02_14-03-04.jpg'
//        ]);
//        Service::create([
//            'title'=>'Data Analytics and Visualization',
//            'description'=>'Utilize data analytics tools and techniques to derive actionable insights from complex data sets and create interactive visualizations for informed decision-making.',
//            'owner_type'=>'App\\Models\\Freelancer',
//            'owner_id'=>'1',
//            'image'=>'service/1',
//            'preview'=>'service/1/photo_1_2024-06-02_14-03-04.jpg'
//        ]);
//        Service::create([
//            'title'=>'DevOps and Continuous Integration/Delivery',
//            'description'=>'Implement DevOps practices to automate software development, testing, and deployment processes, ensuring faster delivery and improved collaboration.',
//            'owner_type'=>'App\\Models\\Freelancer',
//            'owner_id'=>'1',
//            'image'=>'service/1',
//            'preview'=>'service/1/photo_1_2024-06-02_14-03-04.jpg'
//        ]);
    }
}
