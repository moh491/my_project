<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\Review;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('reviews')->truncate();

        // ملاحظات مرجعية باللغة العربية
        $arabicNotes = [
            'المشروع تم تنفيذه بكفاءة عالية مع احترام جميع المواعيد النهائية.',
            'تواصل ممتاز مع العميل وتجاوب سريع مع المتطلبات.',
            'جودة العمل كانت جيدة، ولكن هناك بعض التحسينات المطلوبة.',
            'تسليم المشروع كان في الوقت المحدد، ولكن هناك بعض المشكلات في الأداء.',
            'كانت تجربة العمل مع الفريق رائعة، وتم التعامل مع جميع التحديات بمهارة.',
            'بعض التأخيرات في التسليم، لكن المشروع النهائي كان حسب المواصفات.',
            'التواصل كان جيدًا، ولكن كان هناك بعض المشكلات في جودة التسليم.',
            'المشروع كان مطابقًا للمواصفات، مع بعض التعديلات الطفيفة المطلوبة.',
            'العمل كان رائعًا، لكن كان هناك بعض التأخيرات البسيطة في التسليم.',
            'التجربة العامة كانت إيجابية، ولكن هناك مجال للتحسين في بعض الجوانب.'
        ];

        // ملاحظات مرجعية باللغة الإنجليزية
        $englishNotes = [
            'The project was completed efficiently and met all deadlines.',
            'Excellent communication with the client and quick response to requirements.',
            'The quality of work was good, but some improvements are needed.',
            'The project was delivered on time, but there were some performance issues.',
            'Working with the team was great, and all challenges were handled skillfully.',
            'There were some delays in delivery, but the final project met the specifications.',
            'Communication was good, but there were some issues with the quality of delivery.',
            'The project was as per specifications, with some minor adjustments needed.',
            'The work was excellent, but there were some minor delays in delivery.',
            'The overall experience was positive, but there is room for improvement in some areas.'
        ];

        // الحصول على جميع المشاريع
        $projects = Project::all();

        $arabicProjects = $projects->take(10);
        $englishProjects = $projects->skip(10)->take(10);

        foreach ($arabicProjects as $project) {
            DB::table('reviews')->insert([
                'professionalism' => rand(1, 5),
                'communication' => rand(1, 5),
                'quality' => rand(1, 5),
                'commit_to_deadlines' => rand(1, 5),
                're_employee' => rand(1, 5),
                'experience' => rand(1, 5),
                'description' => $arabicNotes[array_rand($arabicNotes)],
                'project_id' => $project->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        foreach ($englishProjects as $project) {
            DB::table('reviews')->insert([
                'professionalism' => rand(1, 5),
                'communication' => rand(1, 5),
                'quality' => rand(1, 5),
                'commit_to_deadlines' => rand(1, 5),
                're_employee' => rand(1, 5),
                'experience' => rand(1, 5),
                'description' => $englishNotes[array_rand($englishNotes)],
                'project_id' => $project->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
//        Review::truncate();
//        Review::create([
//            'professionalism' => 4,
//        'communication' => 5,
//        'quality' => 3,
//        'commit_to_deadlines' => 3,
//        're_employee' => 4,
//        'experience'=>3,
//        'description' =>'description',
//            'project_id'=>1,
//
//        ]);
//        Review::create([
//            'professionalism' => 4,
//            'communication' => 5,
//            'quality' => 3,
//            'commit_to_deadlines' => 3,
//            're_employee' => 2,
//            'experience'=>3,
//            'description' =>'description',
//            'project_id'=>2,
//
//        ]);
//        Review::create([
//            'professionalism' => 4,
//            'communication' => 5,
//            'quality' => 2,
//            'commit_to_deadlines' => 3,
//            're_employee' => 2,
//            'experience'=>3,
//            'description' =>'description',
//            'project_id'=>3,
//
//        ]);
//        Review::create([
//            'professionalism' => 4,
//            'communication' => 5,
//            'quality' => 2,
//            'commit_to_deadlines' => 3,
//            're_employee' => 4,
//            'experience'=>3,
//            'description' =>'description',
//            'project_id'=>4,
//
//        ]);
    }
}
