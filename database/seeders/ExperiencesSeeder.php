<?php

namespace Database\Seeders;

use App\Enums\Employment_Type;
use App\Enums\Location_Type;
use App\Models\Company;
use App\Models\Experience;
use App\Models\Freelancer;
use App\Models\Position;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class ExperiencesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('experiences')->truncate();

        $locationTypes = [
            Location_Type::ON_SITE,
            Location_Type::HYBRID,
            Location_Type::REMOTE
        ];

        $employmentTypes = [
            Employment_Type::FULL_TIME,
            Employment_Type::PART_TIME,
            Employment_Type::SELF_EMPLOYED,
            Employment_Type::FREELANCE,
            Employment_Type::CONTRACT,
            Employment_Type::INTERNSHIP,
            Employment_Type::SEASONAL,
            Employment_Type::APPRENTICESHIP
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

        $freelancerIds = Freelancer::pluck('id')->toArray();
        $positionIds = Position::pluck('id')->toArray();
        $companyIds = Company::pluck('id')->toArray();

        for ($i = 0; $i < 20; $i++) {
            $freelancerId = $freelancerIds[array_rand($freelancerIds)];
            $positionId = $positionIds[array_rand($positionIds)];

            $freelancer = Freelancer::find($freelancerId);
            $freelancerLocation = $freelancer ? $freelancer->location : 'Unknown Location';
            $freelancerDescription = $freelancer ? $freelancer->description : 'No Description';

            $companyId = !empty($companyIds) ? $companyIds[array_rand($companyIds)] : null;
            $company = $companyId ? Company::find($companyId) : null;
            $companyLocation = $company ? $company->location : $freelancerLocation;

            // Choose a random description from freelancer descriptions
            $description = $freelancerDescriptions[array_rand($freelancerDescriptions)];

            DB::table('experiences')->insert([
                'company_name' => $company ? $company->name : 'Unknown Company',
                'employment_type' => $employmentTypes[array_rand($employmentTypes)],
                'location_type' => $locationTypes[array_rand($locationTypes)],
                'location' => $companyLocation,
                'start_date' => now()->subYears(rand(1, 5))->format('Y-m-d'),
                'end_date' => now()->subYears(rand(0, 4))->format('Y-m-d'),
                'description' => $description, // Use the random freelancer description
                'freelancer_id' => $freelancerId,
                'position_id' => $positionId,
                'company_id' => $companyId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

//        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
//        DB::table('experiences')->truncate();
//
//        $locationTypes = [
//            Location_Type::ON_SITE,
//            Location_Type::HYBRID,
//            Location_Type::REMOTE
//        ];
//
//        $employmentTypes = [
//            Employment_Type::FULL_TIME,
//            Employment_Type::PART_TIME,
//            Employment_Type::SELF_EMPLOYED,
//            Employment_Type::FREELANCE,
//            Employment_Type::CONTRACT,
//            Employment_Type::INTERNSHIP,
//            Employment_Type::SEASONAL,
//            Employment_Type::APPRENTICESHIP
//        ];
//
//        $freelancerDescriptions = [
//            'Experienced Full Stack Developer with a strong background in web development.',
//            'Creative Graphic Designer with over 10 years of experience.',
//            'Professional Data Scientist with a passion for big data analytics.',
//            'Expert in digital marketing and SEO strategies.',
//            'Skilled Mobile App Developer with expertise in both iOS and Android.',
//            'Talented UX/UI Designer focused on creating intuitive user experiences.',
//            'Dedicated Network Engineer with extensive knowledge in network security.',
//            'Proficient Software Tester with a keen eye for detail and quality.',
//            'Passionate Web Developer specializing in front-end technologies.',
//            'Innovative Software Engineer with a focus on scalable applications.'
//        ];
//
//        $companyDescriptions = [
//            'Google is a multinational corporation specializing in Internet-related services and products.',
//            'Facebook is a social media and social networking service.',
//            'Amazon is an e-commerce and cloud computing company.',
//            'Apple designs, manufactures, and markets smartphones, personal computers, tablets, wearables, and accessories.',
//            'Microsoft develops, manufactures, licenses, supports, and sells computer software, consumer electronics, personal computers, and related services.',
//            'Netflix is a streaming service that offers a wide variety of TV shows, movies, anime, documentaries, and more.',
//            'Twitter is a social media platform that allows users to send and read short 280-character messages called tweets.',
//            'LinkedIn is a business and employment-oriented online service that operates via websites and mobile apps.',
//            'Uber is a ride-hailing service that allows users to book a car and driver to transport them in a way similar to a taxi.',
//            'Airbnb is an online marketplace for arranging or offering lodging, primarily homestays, or tourism experiences.',
//            'شركة الاتصالات السعودية هي الشركة الرائدة في مجال الاتصالات في المملكة العربية السعودية.',
//            'مجموعة stc هي مجموعة اتصالات متكاملة تقدم خدمات متنوعة في المملكة العربية السعودية.',
//            'شركة زين هي واحدة من أكبر شركات الاتصالات في الشرق الأوسط.',
//            'شركة دو تقدم خدمات الاتصالات والإنترنت في دولة الإمارات العربية المتحدة.',
//            'شركة اتصالات مصر هي شركة الاتصالات الرائدة في مصر.',
//            'شركة أورانج مصر تقدم خدمات الاتصالات والإنترنت في مصر.',
//            'شركة موبايلي هي شركة اتصالات سعودية تقدم خدمات الهاتف المحمول.',
//            'شركة كريم تقدم خدمات النقل الذكي في الشرق الأوسط.',
//            'شركة سوق دوت كوم هي أكبر منصة للتجارة الإلكترونية في الشرق الأوسط.',
//            'شركة جوميا هي منصة تجارة إلكترونية رائدة في إفريقيا والشرق الأوسط.'
//        ];
//
//        $freelancerIds = Freelancer::pluck('id')->toArray();
//        $positionIds = Position::pluck('id')->toArray();
//        $companyIds = Company::pluck('id')->toArray();
//
//        for ($i = 0; $i < 20; $i++) {
//            $freelancerId = $freelancerIds[array_rand($freelancerIds)];
//            $positionId = $positionIds[array_rand($positionIds)];
//
//            $freelancer = Freelancer::find($freelancerId);
//            $freelancerLocation = $freelancer ? $freelancer->location : 'Unknown Location';
//            $freelancerDescription = $freelancer ? $freelancer->description : 'No Description';
//
//            $companyId = !empty($companyIds) ? $companyIds[array_rand($companyIds)] : null;
//            $company = $companyId ? Company::find($companyId) : null;
//            $companyLocation = $company ? $company->location : $freelancerLocation;
//            $companyDescription = $company ? $company->description : $freelancerDescription;
//
//            if (!$companyDescription) {
//                $companyDescription = 'Default Company Description'; // Use a default description if NULL
//            }
//
//            DB::table('experiences')->insert([
//                'company_name' => $company ? $company->name : 'Unknown Company',
//                'employment_type' => $employmentTypes[array_rand($employmentTypes)],
//                'location_type' => $locationTypes[array_rand($locationTypes)],
//                'location' => $companyLocation,
//                'start_date' => now()->subYears(rand(1, 5))->format('Y-m-d'),
//                'end_date' => now()->subYears(rand(0, 4))->format('Y-m-d'),
//                'description' => $companyDescription, // Ensure description is not null
//                'freelancer_id' => $freelancerId,
//                'position_id' => $positionId,
//                'company_id' => $companyId,
//                'created_at' => now(),
//                'updated_at' => now(),
//            ]);
//        }
//
//        DB::statement('SET FOREIGN_KEY_CHECKS=1;');


//        Experience::create([
//            'company_name'=>'OurCompany',
//            'employment_type'=>1,
//            'location_type'=>1,
//            'location'=>'Damascus, Syria',
//            'start_date'=>'2024-05-01',
//            'end_date'=>'2025-05-03',
//            'freelancer_id'=>1,
//            'description'=>'Frontend developers specialize in building engaging user interfaces (UIs) and interactive web applications that users interact with directly in their web browsers. They focus on the presentation layer of web development, translating designs into functional and responsive interfaces using HTML, CSS, and JavaScript.',
//            'position_id'=>1,
//            'company_id'=>1,
//        ]);
//        Experience::create([
//            'company_name'=>'Meta',
//            'employment_type'=>2,
//            'location_type'=>2,
//            'location'=>'Damascus, Syria',
//            'start_date'=>'2024-05-01',
//            'end_date'=>'2025-05-03',
//            'freelancer_id'=>1,
//            'description'=>'As a backend developer, individuals specialize in designing, implementing, and maintaining the server-side logic of web applications and software systems. They play a crucial role in building the foundation and architecture that supports the frontend user interface and ensures smooth functionality of the entire application.',
//            'position_id'=>2,
//            'company_id'=>2,
//        ]);
    }
}
