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

        $statuses = [ 'Completed', 'Under Review', 'Closed'];
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
            'John Smith' => 'Comprehensive Project Management System',
            'Jane Doe' => 'Innovative Tech Startup Application',
            'Michael Johnson' => 'Cross-Functional Team Collaboration Platform',
            'Emily Davis' => 'Agile Project Management System',
            'David Brown' => 'Process Improvement Project',
            'Sophia Wilson' => 'Enterprise Risk Management',
            'James Taylor' => 'Large Team Collaboration App',
            'Olivia Martinez' => 'Project Workflow Optimization',
            'William Anderson' => 'Complex Project Challenges Solutions',
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

        $projects = [];
        $projectSkillMappings = [];


        $user=['App\\Models\\Freelancer','App\\Models\\Team'];
        foreach ($owners as $index => $owner) {
            $field = $fields->random();
            $projectId = DB::table('projects')->insertGetId([
                'title' => $titles[$owner->first_name . ' ' . $owner->last_name] ?? 'General Project',
                'description' => $descriptions[$index % count($descriptions)],
                'duration' => rand(1, 12),
                'min_budget' => rand(500, 1000),
                'max_budget' => rand(1000, 5000),
                'status' => $statuses[array_rand($statuses)],
                'project_owner_id' => $owner->id,
                'field_id' => $field->id,
                'start_date' => '2024-03-1',
                'end_date' => '2024-03-15',
                'created_at' => now(),
                'updated_at' => now(),
                'worker_type'=>$user[array_rand($user)],
                'worker_id'=>1,
            ]);
            Project::create([
                'title'=>'Online Clothing Store',
                'description'=>'Built an e-commerce website for a clothing store using React.js and Django. Integrated payment gateway for online transactions, implemented product catalog with filtering and sorting functionalities, and optimized performance for a seamless shopping experience.',
                'min_budget'=>1000,
                'max_budget'=>2000,
                'status'=>4,
                'project_owner_id'=>1,
                'field_id'=>3,
                'duration'=>12,
                'worker_type'=>'App\\Models\\Freelancer',
                'worker_id'=>1,
            ]);
            Project::create([
                'title'=>'Online Clothing Store',
                'description'=>'Built an e-commerce website for a clothing store using React.js and Django. Integrated payment gateway for online transactions, implemented product catalog with filtering and sorting functionalities, and optimized performance for a seamless shopping experience.',
                'min_budget'=>1000,
                'max_budget'=>2000,
                'status'=>4,
                'project_owner_id'=>1,
                'field_id'=>3,
                'duration'=>12,
                'worker_type'=>'App\\Models\\Freelancer',
                'worker_id'=>1,
            ]);
            Project::create([
                'title'=>'Online Clothing Store',
                'description'=>'Built an e-commerce website for a clothing store using React.js and Django. Integrated payment gateway for online transactions, implemented product catalog with filtering and sorting functionalities, and optimized performance for a seamless shopping experience.',
                'min_budget'=>1000,
                'max_budget'=>2000,
                'status'=>4,
                'project_owner_id'=>1,
                'field_id'=>3,
                'duration'=>12,
                'worker_type'=>'App\\Models\\Team',
                'worker_id'=>1,
            ]);
            Project::create([
                'title'=>'Online Clothing Store',
                'description'=>'Built an e-commerce website for a clothing store using React.js and Django. Integrated payment gateway for online transactions, implemented product catalog with filtering and sorting functionalities, and optimized performance for a seamless shopping experience.',
                'min_budget'=>1000,
                'max_budget'=>2000,
                'status'=>4,
                'project_owner_id'=>1,
                'field_id'=>3,
                'duration'=>12,
                'worker_type'=>'App\\Models\\Team',
                'worker_id'=>1,
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
