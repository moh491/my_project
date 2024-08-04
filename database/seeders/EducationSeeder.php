<?php

namespace Database\Seeders;

use App\Models\Education;
use App\Models\Freelancer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EducationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('education')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');


        $freelancers = DB::table('freelancers')->get();


        $educationData = [
            'Diploma in Professional Studies' => [
                'description' => 'A comprehensive diploma program covering essential aspects of professional studies, including practical and theoretical knowledge.',
                'years' => [now()->subYears(4)->format('Y-m-d'), now()->subYears(3)->format('Y-m-d')],
            ],
            'Master\'s Degree in Professional Studies' => [
                'description' => 'An advanced degree focusing on specialized knowledge and skills in professional studies, including research and practical applications.',
                'years' => [now()->subYears(3)->format('Y-m-d'), now()->subYears(2)->format('Y-m-d')],
            ]
        ];


        $institutions = [
            'Berlin, Germany' => ['Technical University of Berlin', 'Humboldt University of Berlin'],
            'London, UK' => ['University College London', 'Imperial College London'],
            'Paris, France' => ['Sorbonne University', 'University of Paris'],
            'Madrid, Spain' => ['University of Madrid', 'Complutense University of Madrid'],
            'Rome, Italy' => ['Sapienza University of Rome', 'University of Rome Tor Vergata'],
            'Amsterdam, Netherlands' => ['University of Amsterdam', 'Vrije Universiteit Amsterdam'],
            'Vienna, Austria' => ['University of Vienna', 'Vienna University of Technology'],
            'Zurich, Switzerland' => ['ETH Zurich', 'University of Zurich'],
            'Brussels, Belgium' => ['Université libre de Bruxelles', 'University of Brussels'],
            'Lisbon, Portugal' => ['University of Lisbon', 'Instituto Superior Técnico'],
            'الرياض، السعودية' => ['جامعة الملك سعود', 'جامعة الأميرة نورة'],
            'دبي، الإمارات' => ['جامعة دبي', 'الجامعة الأمريكية في دبي'],
            'القاهرة، مصر' => ['جامعة القاهرة', 'جامعة عين شمس'],
            'الدوحة، قطر' => ['جامعة قطر', 'كلية شمال الأطلنطي في قطر'],
            'الكويت، الكويت' => ['جامعة الكويت', 'الجامعة الأمريكية في الكويت'],
            'عمان، الأردن' => ['الجامعة الأردنية', 'جامعة الأميرة سمية للتكنولوجيا'],
            'بيروت، لبنان' => ['الجامعة الأمريكية في بيروت', 'جامعة القديس يوسف'],
            'بغداد، العراق' => ['جامعة بغداد', 'جامعة النهرين'],
            'المنامة، البحرين' => ['جامعة البحرين', 'الجامعة الأهلية'],
            'مسقط، عمان' => ['جامعة السلطان قابوس', 'الجامعة الوطنية العمانية']
        ];
        $averages=range(79,88);


        foreach ($freelancers as $freelancer) {

            $location = $freelancer->location;
            $about = $freelancer->about;


            $institutionsForLocation = $institutions[$location] ?? [];


            if (!empty($institutionsForLocation)) {
                foreach ($educationData as $title => $data) {
                    DB::table('education')->insert([
                        'title' => $title,
                        'institution' => $institutionsForLocation[array_rand($institutionsForLocation)],
                        'location' => $location,
                        'start_year' => $data['years'][0],
                        'end_year' => $data['years'][1],
                        'average' => $averages[array_rand($averages)],
                        'description' => "In this role as a {$about}, the freelancer pursued this education to enhance their skills and knowledge.",
                        'freelancer_id' => $freelancer->id,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            } else {
                foreach ($educationData as $title => $data) {
                    DB::table('education')->insert([
                        'title' => $title,
                        'institution' => 'Unknown Institution',
                        'location' => $location,
                        'start_year' => $data['years'][0],
                        'end_year' => $data['years'][1],
                        'average' => $averages[array_rand($averages)],
                        'description' => "In this role as a {$about}, the freelancer pursued this education to enhance their skills and knowledge.",
                        'freelancer_id' => $freelancer->id,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        }

//        Education::truncate();
//        Education::create([
//        'title'=>'Advanced Diploma In Multimedia',
//        'institution'=>'Damascus UnUniversity',
//            'start_year'=>'2024-05-01',
//            'end_year'=>'2027-05-01',
//        'average'=>70,
//        'description'=>'The Advanced Diploma in Multimedia program offers a blend of theoretical knowledge and hands-on practical training, preparing students for careers in digital media, interactive design, animation, and visual communication. The curriculum is carefully crafted to cover a wide range of topics essential for success in the multimedia industry.',
//        'freelancer_id'=>1,
//            'location'=>'Damascus, Syria'
//    ]);
//        Education::create([
//            'title'=>'Advanced Diploma In Algorithm',
//            'institution'=>'Damascus UnUniversity',
//            'location'=>'Damascus, Syria',
//            'start_year'=>'2024-05-01',
//            'end_year'=>'2027-05-01',
//            'average'=>60,
//            'description'=>'The Advanced Diploma in Algorithm program is designed to provide students with advanced theoretical knowledge and practical skills in algorithm development, optimization, and analysis. Students explore complex algorithms used in software development, artificial intelligence, data science, and computational biology.',
//            'freelancer_id'=>1,
//        ]);


    }
}
