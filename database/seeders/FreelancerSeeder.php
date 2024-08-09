<?php

namespace Database\Seeders;

use App\Models\Application;
use App\Models\Freelancer;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;


class FreelancerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        Freelancer::truncate();


        Freelancer::create([
            'first_name'=>'Loujain',
            'last_name'=>'Diab',
            'email'=>'loujaindiab551@gmail.com',
            'email_verified_at'=>'2023-06-11 19:25:02',
            'password'=>bcrypt('password'),
            'position_id'=>1,
            'about'=>'The description of the freelancer',
            'location'=>'Damascus, Syria',
            'profile'=>'freelancer-profile/OIP (1).jpg',
            'suspended_balance'=>100,
            'available_balance'=>200,
            'withdrawal_balance'=>400,
            'time_zone'=>'EET UTC+3',
        ]);

        Freelancer::create([
            'first_name'=>'Sara',
            'last_name'=>'Mak',
            'email'=>'sara@gmail.com',
            'email_verified_at'=>'2023-06-11 19:25:02',
            'password'=>bcrypt('password'),
            'position_id'=>2,
            'about'=>'The description of the freelancer',
            'location'=>'Damascus, Syria',
            'profile'=>'freelancer-profile/OIP (1).jpg',
            'suspended_balance'=>100,
            'available_balance'=>200,
            'withdrawal_balance'=>400,
            'time_zone'=>'EET UTC+3',
        ]);

        $firstNames = [
            'en' => ['John', 'Jane', 'Robert', 'Emily', 'Michael', 'Sarah', 'David', 'Laura', 'James', 'Olivia'],
            'ar' => ['أحمد', 'فاطمة', 'محمد', 'خديجة', 'علي', 'زينب', 'يوسف', 'عائشة', 'عبدالله', 'سلمى']
        ];

        $lastNames = [
            'en' => ['Doe', 'Smith', 'Brown', 'Davis', 'Johnson', 'White', 'Harris', 'Miller', 'Wilson', 'Moore'],
            'ar' => ['الأنصاري', 'النجار', 'الحسيني', 'العمر', 'المحمدي', 'السعدي', 'العلي', 'المبارك', 'الخالد', 'العبدالله']
        ];

        $emails = [
            'en' => ['john.doe@example.com', 'jane.smith@example.com', 'robert.brown@example.com', 'emily.davis@example.com', 'michael.johnson@example.com', 'sarah.white@example.com', 'david.harris@example.com', 'laura.miller@example.com', 'james.wilson@example.com', 'olivia.moore@example.com'],
            'ar' => ['ahmed@example.com', 'fatima@example.com', 'mohammed@example.com', 'khadija@example.com', 'ali@example.com', 'zainab@example.com', 'yousef@example.com', 'aisha@example.com', 'abdullah@example.com', 'salma@example.com']
        ];

        $locations = [
            'en' => ['Berlin, Germany', 'London, UK', 'Paris, France', 'Madrid, Spain', 'Rome, Italy', 'Amsterdam, Netherlands', 'Vienna, Austria', 'Zurich, Switzerland', 'Brussels, Belgium', 'Lisbon, Portugal'],
            'ar' => ['الرياض، السعودية', 'دبي، الإمارات', 'القاهرة، مصر', 'الدوحة، قطر', 'الكويت، الكويت', 'عمان، الأردن', 'بيروت، لبنان', 'بغداد، العراق', 'المنامة، البحرين', 'مسقط، عمان']
        ];

        $timeZones = [
            'en' => ['Europe/Berlin', 'Europe/London', 'Europe/Paris', 'Europe/Madrid', 'Europe/Rome', 'Europe/Amsterdam', 'Europe/Vienna', 'Europe/Zurich', 'Europe/Brussels', 'Europe/Lisbon'],
            'ar' => ['Asia/Riyadh', 'Asia/Dubai', 'Africa/Cairo', 'Asia/Qatar', 'Asia/Kuwait', 'Asia/Amman', 'Asia/Beirut', 'Asia/Baghdad', 'Asia/Bahrain', 'Asia/Muscat']
        ];

        $abouts = [
            'en' => [
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
            ],
            'ar' => [
                'مهندس برمجيات ذو خبرة واسعة في تطوير الويب.',
                'مصمم جرافيك مبدع مع أكثر من 10 سنوات من الخبرة.',
                'عالم بيانات محترف وشغوف بتحليل البيانات الكبيرة.',
                'خبير في التسويق الرقمي واستراتيجيات تحسين محركات البحث.',
                'مطور تطبيقات جوال ماهر في تطوير تطبيقات iOS و Android.',
                'مصمم UX/UI موهوب يركز على إنشاء تجارب مستخدم بديهية.',
                'مهندس شبكات مخلص يمتلك معرفة واسعة في أمان الشبكات.',
                'مُختبِر برمجيات متمرس يتمتع بدقة عالية وجودة.',
                'محلل بيانات ذو خبرة في تحليل البيانات الكبيرة.',
                'مطور واجهات استخدام مع خلفية قوية في تطوير البرمجيات.'
            ]
        ];

        $profiles = [
            'en' => ['john_doe.jpg', 'jane_smith.jpg', 'robert_brown.jpg', 'emily_davis.jpg', 'michael_johnson.jpg', 'sarah_white.jpg', 'david_harris.jpg', 'laura_miller.jpg', 'james_wilson.jpg', 'olivia_moore.jpg'],
            'ar' => ['ahmed.jpg', 'fatima.jpg', 'mohammed.jpg', 'khadija.jpg', 'ali.jpg', 'zainab.jpg', 'yousef.jpg', 'aisha.jpg', 'abdullah.jpg', 'salma.jpg']
        ];

        $balances = [
            'withdrawal_balance' => [1200.50, 850.25, 500.00, 700.75, 1300.00, 900.00, 400.50, 1100.00, 600.75, 1400.00],
            'available_balance' => [3000.75, 1500.00, 2000.00, 2500.50, 3500.00, 2700.25, 2200.75, 3100.00, 1900.50, 3600.75],
            'suspended_balance' => [0, 100.50, 50.00, 75.25, 0, 0, 20.50, 30.75, 15.00, 0]
        ];


        $positionIds = [
            'en' => [
                'Experienced Full Stack Developer with a strong background in web development.' => 1,
                'Creative Graphic Designer with over 10 years of experience.' => 2,
                'Professional Data Scientist with a passion for big data analytics.' => 4,
                'Expert in digital marketing and SEO strategies.' => 1,
                'Skilled Mobile App Developer with expertise in both iOS and Android.' => 3,
                'Talented UX/UI Designer focused on creating intuitive user experiences.' => 6,
                'Dedicated Network Engineer with extensive knowledge in network security.' => 13,
                'Proficient Software Tester with a keen eye for detail and quality.' => 8,
                'Passionate Web Developer specializing in front-end technologies.' => 1,
                'Innovative Software Engineer with a focus on scalable applications.' => 1,
            ],
            'ar' => [
                'مهندس برمجيات ذو خبرة واسعة في تطوير الويب.' => 1,
                'مصمم جرافيك مبدع مع أكثر من 10 سنوات من الخبرة.' => 2,
                'عالم بيانات محترف وشغوف بتحليل البيانات الكبيرة.' => 4,
                'خبير في التسويق الرقمي واستراتيجيات تحسين محركات البحث.' => 1,
                'مطور تطبيقات جوال ماهر في تطوير تطبيقات iOS و Android.' => 3,
                'مصمم UX/UI موهوب يركز على إنشاء تجارب مستخدم بديهية.' => 6,
                'مهندس شبكات مخلص يمتلك معرفة واسعة في أمان الشبكات.' => 13,
                'مُختبِر برمجيات متمرس يتمتع بدقة عالية وجودة.' => 8,
                'محلل بيانات ذو خبرة في تحليل البيانات الكبيرة.' => 4,
                'مطور واجهات استخدام مع خلفية قوية في تطوير البرمجيات.' => 1,
            ]
        ];

        $password = Hash::make('password');

         for ($i = 0; $i < 10; $i++) {
            DB::table('freelancers')->insert([
                'first_name' => $firstNames['en'][$i],
                'last_name' => $lastNames['en'][$i],
                'email' => $emails['en'][$i],
                'email_verified_at' => now(),
                'password' => $password,
                'location' => $locations['en'][$i],
                'time_zone' => $timeZones['en'][$i],
                'profile' => $profiles['en'][$i],
                'withdrawal_balance' => $balances['withdrawal_balance'][$i],
                'available_balance' => $balances['available_balance'][$i],
                'suspended_balance' => $balances['suspended_balance'][$i],
                'about' => $abouts['en'][$i],
                'position_id' => $positionIds['en'][$abouts['en'][$i]],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        for ($i = 0; $i < 10; $i++) {
            DB::table('freelancers')->insert([
                'first_name' => $firstNames['ar'][$i],
                'last_name' => $lastNames['ar'][$i],
                'email' => $emails['ar'][$i],
                'email_verified_at' => now(),
                'password' => $password,
                'location' => $locations['ar'][$i],
                'time_zone' => $timeZones['ar'][$i],
                'profile' => $profiles['ar'][$i],
                'withdrawal_balance' => $balances['withdrawal_balance'][$i],
                'available_balance' => $balances['available_balance'][$i],
                'suspended_balance' => $balances['suspended_balance'][$i],
                'about' => $abouts['ar'][$i],
                'position_id' => $positionIds['ar'][$abouts['ar'][$i]],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }




        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
