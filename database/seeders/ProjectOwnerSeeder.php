<?php

namespace Database\Seeders;


use App\Models\Project_Owners;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ProjectOwnerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('project__owners')->truncate();
        DB::table('field__project_owners')->truncate();

        Project_Owners::create([
            'first_name'=>'Loujain',
            'last_name'=>'Diab',
            'email'=>'loujain@gmail.com',
            'email_verified_at'=>'2023-06-11 19:25:02',
            'password'=>bcrypt('password'),
            'about'=>'The description of the project owner',
            'location'=>'Damascus, Syria',
            'time_zone'=>'EET UTC+3',
            'withdrawal_balance'=>'200',
            'suspended_balance'=>'2000',
            'profile'=>'project-owner-profile/OIP (1).jpg',
        ]);
        Project_Owners::create([
            'first_name'=>'Huda',
            'last_name'=>'Shaker',
            'email_verified_at'=>'2023-06-11 19:25:02',
            'email'=>'Huda@gmail.com',
            'password'=>bcrypt('password'),
            'about'=>'The description of the project owner',
            'location'=>'Damascus, Syria',
            'time_zone'=>'EET UTC+3',
            'withdrawal_balance'=>'200',
            'suspended_balance'=>'2000',
            'profile'=>'project-owner-profile/OIP (1).jpg',
        ]);
        Project_Owners::create([
            'first_name'=>'Sara',
            'last_name'=>'Mak',
            'email'=>'Sara@gmail.com',
            'email_verified_at'=>'2023-06-11 19:25:02',
            'password'=>bcrypt('password'),
            'about'=>'The description of the project owner',
            'location'=>'Damascus, Syria',
            'time_zone'=>'EET UTC+3',
            'withdrawal_balance'=>'200',
            'suspended_balance'=>'2000',
            'profile'=>'project-owner-profile/OIP (1).jpg',
        ]);

        $firstNames = [
            'علي', 'فاطمة', 'حسن', 'سارة', 'يوسف',
            'نجلاء', 'محمد', 'نور', 'عمر', 'أمينة',
            'John', 'Jane', 'Michael', 'Emily', 'David',
            'Sophia', 'James', 'Olivia', 'William', 'Isabella'
        ];

        $lastNames = [
            'أحمد', 'محمد', 'عبد الله', 'خالد', 'عبد الرحمن',
            'مصطفى', 'سامي', 'الهدى', 'جمال', 'أحمد',
            'Smith', 'Doe', 'Johnson', 'Davis', 'Brown',
            'Wilson', 'Taylor', 'Martinez', 'Anderson', 'Thomas'
        ];

        $emails = [
            'ali.ahmed@example.com', 'fatima.mohamed@example.com', 'hassan.abdullah@example.com', 'sara.khaled@example.com', 'yusuf.abdelrahman@example.com',
            'najla.mustafa@example.com', 'mohamed.sami@example.com', 'noor.eldahaby@example.com', 'omar.jamal@example.com', 'amina.ahmed@example.com',
            'john.smith@example.com', 'jane.doe@example.com', 'michael.johnson@example.com', 'emily.davis@example.com', 'david.brown@example.com',
            'sophia.wilson@example.com', 'james.taylor@example.com', 'olivia.martinez@example.com', 'william.anderson@example.com', 'isabella.thomas@example.com'
        ];

        $locations = [
            'القاهرة، مصر', 'الرياض، السعودية', 'دبي، الإمارات', 'المنامة، البحرين', 'مسقط، عمان',
            'الدوحة، قطر', 'بيروت، لبنان', 'عمّان، الأردن', 'الكويت', 'الجزائر',
            'New York, USA', 'San Francisco, USA', 'Los Angeles, USA', 'Chicago, USA', 'Houston, USA',
            'Philadelphia, USA', 'Washington, USA', 'Boston, USA', 'Miami, USA', 'Dallas, USA'
        ];

        $timeZones = [
            'Africa/Cairo', 'Asia/Riyadh', 'Asia/Dubai', 'Asia/Bahrain', 'Asia/Muscat',
            'Asia/Qatar', 'Asia/Beirut', 'Asia/Amman', 'Asia/Kuwait', 'Africa/Algiers',
            'America/New_York', 'America/Los_Angeles', 'America/Chicago', 'America/Houston', 'America/Philadelphia',
            'America/Washington', 'America/Boston', 'America/Miami', 'America/Dallas', 'America/Denver'
        ];

        $about = [
            'مدير مشاريع ذو خبرة واسعة في إدارة المشاريع المعقدة.',
            'رائد أعمال ماهر لديه خلفية في الشركات الناشئة والتكنولوجيا.',
            'شغوف بقيادة الفرق متعددة التخصصات لتحقيق الأهداف الاستراتيجية.',
            'ذو خبرة في منهجيات إدارة المشاريع الرشيقة والشلال.',
            'سجل حافل في تسليم المشاريع في الوقت المحدد وضمن الميزانية.',
            'خبير في إدارة المخاطر واستراتيجيات التخفيف.',
            'مهارات قيادة قوية مع خبرة في إدارة الفرق الكبيرة.',
            'مكرس لتحسين العمليات وتحسين سير العمل في المشاريع.',
            'مفكر استراتيجي لديه قدرة على حل تحديات المشاريع المعقدة.',
            'ماهر في إدارة المساهمين والحفاظ على علاقات قوية مع العملاء.',
            'Experienced ServiceMail Manager with a strong track record in managing complex projects.',
            'Skilled Entrepreneur with a background in tech startups and innovation.',
            'Passionate about leading cross-functional teams to achieve strategic goals.',
            'Experienced in both agile and waterfall project management methodologies.',
            'Proven track record in delivering projects on time and within budget.',
            'Expert in risk management and mitigation strategies.',
            'Strong leadership skills with experience in managing large teams.',
            'Dedicated to improving processes and optimizing project workflows.',
            'Strategic thinker with a knack for solving complex project challenges.',
            'Skilled in stakeholder management and maintaining strong client relationships.'
        ];

        $projectOwners = [];

        foreach (range(0, 9) as $index) {
            $projectOwners[] = [
                'first_name' => $firstNames[$index],
                'last_name' => $lastNames[$index],
                'email' => $emails[$index],
                'password' => Hash::make('password'),
                'location' => $locations[$index],
                'time_zone' => $timeZones[$index],
                'profile' => null,
                'email_verified_at'=>now(),
                'about' => $about[$index],
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('project__owners')->insert($projectOwners);

        $fieldIds = DB::table('fields')->pluck('id')->toArray();
        $projectOwnerIds = DB::table('project__owners')->pluck('id')->toArray();

        foreach ($projectOwnerIds as $ownerId) {
            foreach (array_rand(array_flip($fieldIds), 3) as $fieldId) {
                DB::table('field__project_owners')->insert([
                    'project__owners_id' => $ownerId,
                    'field_id' => $fieldId,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }
        }
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
