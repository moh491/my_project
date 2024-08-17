<?php

namespace Database\Seeders;

use App\Models\Field;
use App\Models\Project;
use App\Models\Project_Owners;
use App\Models\Skill;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('projects')->truncate();
        // DB::table('skillable__skills')->truncate(); // Ensure the pivot table is also truncated

        $statuses = ['Completed', 'Under Review', 'Closed'];
        $owners = Project_Owners::all();
        $fields = Field::all();
        $skills = Skill::all();

        $titles = [
            'علي أحمد' => 'نظام إدارة المشاريع المتكامل',
            'فاطمة محمد' => 'تطبيق الشركات الناشئة الجديد',
            'حسن عبد الله' => 'منصة التعاون الفريقية',
            'سارة خالد' => 'نظام إدارة المشاريع الرشيقة',
            'يوسف عبد الرحمن' => 'مشروع تحسين العمليات',
            'نجلاء مصطفى' => 'إدارة المخاطر للمؤسسات',
            'محمد سامي' => 'تطوير تطبيق للفرق الكبيرة',
            'نور الهدى' => 'تحسين سير العمل في المشاريع',
            'عمر جمال' => 'حلول تحديات المشاريع المعقدة',
            'أمينة أحمد' => 'إدارة العلاقات مع العملاء',
            'John Smith' => 'Comprehensive ServiceMail Management System',
            'Jane Doe' => 'Innovative Tech Startup Application',
            'Michael Johnson' => 'Cross-Functional Team Collaboration Platform',
            'Emily Davis' => 'Agile ServiceMail Management System',
            'David Brown' => 'Process Improvement ServiceMail',
            'Sophia Wilson' => 'Enterprise Risk Management',
            'James Taylor' => 'Large Team Collaboration App',
            'Olivia Martinez' => 'ServiceMail Workflow Optimization',
            'William Anderson' => 'Complex ServiceMail Challenges Solutions',
            'Isabella Thomas' => 'Client Relationship Management'
        ];

        $descriptions = [
            'نظام شامل لإدارة المشاريع يستخدم أحدث الأطر التكنولوجية.',
            'تطوير تطبيق مخصص للشركات الناشئة ذو إمكانيات متعددة المنصات.',
            'منصة لتحليل البيانات الكبيرة واستخراج الرؤى القيمة.',
            'تصميم واجهة مستخدم وتجربة مستخدم سهلة الاستخدام وجذابة.',
            'تنفيذ حلول سحابية لتحسين أداء النظام.',
            'إنشاء بنية تحتية شبكية آمنة وقوية.',
            'تطوير نموذج تعلم آلي لتحسين التحليلات التنبؤية.',
            'مشروع تطوير كامل لمنصة تجارة إلكترونية.',
            'بناء نظام خلفي قابل للتوسع عالي الأداء.',
            'تصميم لعبة ذات رسومات وآليات لعب جذابة.',
            'A comprehensive web development project using modern frameworks.',
            'Developing a mobile application with cross-platform capabilities.',
            'A data analysis project focusing on big data insights.',
            'Designing a user-friendly and intuitive UI/UX for a new application.',
            'Implementing cloud solutions for improved system performance.',
            'Creating a secure and robust network infrastructure.',
            'Developing a machine learning model to enhance predictive analytics.',
            'A full-stack development project for an e-commerce platform.',
            'Building a backend system with high scalability and performance.',
            'Designing a game with engaging graphics and gameplay mechanics.'
        ];

        $idealSkills = [
            'نظام شامل لإدارة المشاريع يستخدم أحدث الأطر التكنولوجية.' => ['ServiceMail Management', 'Agile', 'Scrum'],
            'تطوير تطبيق مخصص للشركات الناشئة ذو إمكانيات متعددة المنصات.' => ['Mobile Development', 'Cross-Platform', 'Startup Tech'],
            'منصة لتحليل البيانات الكبيرة واستخراج الرؤى القيمة.' => ['Data Analysis', 'Big Data', 'Analytics'],
            'تصميم واجهة مستخدم وتجربة مستخدم سهلة الاستخدام وجذابة.' => ['UI/UX Design', 'User Experience', 'Prototyping'],
            'تنفيذ حلول سحابية لتحسين أداء النظام.' => ['Cloud Solutions', 'System Performance', 'Infrastructure'],
            'إنشاء بنية تحتية شبكية آمنة وقوية.' => ['Network Security', 'Infrastructure', 'Secure Networking'],
            'تطوير نموذج تعلم آلي لتحسين التحليلات التنبؤية.' => ['Machine Learning', 'Predictive Analytics', 'AI'],
            'مشروع تطوير كامل لمنصة تجارة إلكترونية.' => ['E-Commerce', 'Full-Stack Development', 'React.js', 'Django'],
            'بناء نظام خلفي قابل للتوسع عالي الأداء.' => ['Backend Development', 'Scalability', 'Performance Optimization'],
            'تصميم لعبة ذات رسومات وآليات لعب جذابة.' => ['Game Design', 'Graphics', 'Gameplay Mechanics'],
            'A comprehensive web development project using modern frameworks.' => ['Web Development', 'Modern Frameworks', 'Full-Stack'],
            'Developing a mobile application with cross-platform capabilities.' => ['Mobile App Development', 'Cross-Platform', 'iOS', 'Android'],
            'A data analysis project focusing on big data insights.' => ['Data Analysis', 'Big Data', 'Data Insights'],
            'Designing a user-friendly and intuitive UI/UX for a new application.' => ['UI/UX Design', 'User Interface', 'Intuitive Design'],
            'Implementing cloud solutions for improved system performance.' => ['Cloud Solutions', 'System Performance', 'Cloud Infrastructure'],
            'Creating a secure and robust network infrastructure.' => ['Network Security', 'Infrastructure', 'Secure Networks'],
            'Developing a machine learning model to enhance predictive analytics.' => ['Machine Learning', 'Predictive Analytics', 'Data Science'],
            'A full-stack development project for an e-commerce platform.' => ['Full-Stack Development', 'E-Commerce', 'React.js', 'Django'],
            'Building a backend system with high scalability and performance.' => ['Backend Development', 'Scalability', 'Performance Optimization'],
            'Designing a game with engaging graphics and gameplay mechanics.' => ['Game Design', 'Graphics', 'Gameplay Mechanics']
        ];

        $projects = [];
        $projectSkillMappings = [];

        $user = ['App\\Models\\Freelancer', 'App\\Models\\Team'];
        foreach ($owners as $index => $owner) {
            $field = $fields->random();
            $description = $descriptions[$index % count($descriptions)];
            $idealSkillsForDescription = $idealSkills[$description] ?? [];

             Log::info("Creating project with description: $description");
            Log::info("Ideal skills: ", $idealSkillsForDescription);

            $projectId = DB::table('projects')->insertGetId([
                'title' => $titles[$owner->first_name . ' ' . $owner->last_name] ?? 'General ServiceMail',
                'description' => $description,
                'duration' => rand(1, 12),
                'min_budget' => rand(500, 1000),
                'max_budget' => rand(1000, 2000),
                'status' => $statuses[array_rand($statuses)],
                'project_owner_id' => $owner->id,
                'field_id' => $field->id,
                'start_date' => '2024-03-1',
                'end_date' => '2024-03-15',
                'created_at' => now(),
                'updated_at' => now(),
                'worker_type' => $user[array_rand($user)],
                'worker_id' => 1,
                'ideal_skills' => json_encode($idealSkillsForDescription), // Adding ideal_skills
            ]);

             $commonDescription = 'Built an e-commerce website for a clothing store using React.js and Django. Integrated payment gateway for online transactions, implemented product catalog with filtering and sorting functionalities, and optimized performance for a seamless shopping experience.';
            $commonIdealSkills = ['Web Development', 'E-Commerce', 'React.js', 'Django'];

            Project::create([
                'title' => 'Online Clothing Store',
                'description' => $commonDescription,
                'min_budget' => 1000,
                'max_budget' => 2000,
                'status' => 4,
                'project_owner_id' => 1,
                'field_id' => 3,
                'duration' => 12,
                'worker_type' => 'App\\Models\\Freelancer',
                'worker_id' => 1,
                'ideal_skills' => json_encode($commonIdealSkills),
            ]);

            Project::create([
                'title' => 'Online Clothing Store',
                'description' => $commonDescription,
                'min_budget' => 1000,
                'max_budget' => 2000,
                'status' => 4,
                'project_owner_id' => 1,
                'field_id' => 3,
                'duration' => 12,
                'worker_type' => 'App\\Models\\Freelancer',
                'worker_id' => 1,
                'ideal_skills' => json_encode($commonIdealSkills),
            ]);

            Project::create([
                'title' => 'Online Clothing Store',
                'description' => $commonDescription,
                'min_budget' => 1000,
                'max_budget' => 2000,
                'status' => 4,
                'project_owner_id' => 1,
                'field_id' => 3,
                'duration' => 12,
                'worker_type' => 'App\\Models\\Team',
                'worker_id' => 1,
                'ideal_skills' => json_encode($commonIdealSkills),
            ]);

            Project::create([
                'title' => 'Online Clothing Store',
                'description' => $commonDescription,
                'min_budget' => 1000,
                'max_budget' => 2000,
                'status' => 4,
                'project_owner_id' => 1,
                'field_id' => 3,
                'duration' => 12,
                'worker_type' => 'App\\Models\\Team',
                'worker_id' => 1,
                'ideal_skills' => json_encode($commonIdealSkills),
            ]);

            $randomSkillsCount = min(2, $skills->count());
            $randomSkills = $skills->random($randomSkillsCount)->pluck('id')->toArray();
            foreach ($randomSkills as $skillId) {
                $projectSkillMappings[] = [
                    'skillable_id' => $projectId,
                    'skillable_type' => 'App\Models\Project',
                    'skill_id' => $skillId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        DB::table('skillable__skills')->insert($projectSkillMappings);
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
