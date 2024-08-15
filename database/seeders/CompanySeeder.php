<?php

namespace Database\Seeders;

use App\Models\Company;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Company::truncate();

         Company::create([
            'name'=>'Google',
            'email'=>'contact@google.com',
            'email_verified_at'=>'2023-06-11 19:25:02',
            'logo'=>'google.png',
            'website'=>'https://www.google.com',
            'password'=>'111111',
            'field_id'=>1,
            'about'=>'Google is a multinational corporation specializing in Internet-related services and products.',
            'location'=>'Mountain View, CA',

       ]);
//        Company::create([
//            'name'=>'Meta',
//            'email'=>'Meta@gmail.com',
//            'email_verified_at'=>'2023-06-11 19:25:02',
//            'logo'=>' ',
//            'background_image'=>' ',
//            'password'=>'111111',
//            'field_id'=>2,
//            'about'=>'The description of the company',
//            'location'=>'Damascus-Syria',
//        ]);
        $names = [
              'Facebook', 'Amazon', 'Apple', 'Microsoft',
            'Netflix', 'Twitter', 'LinkedIn', 'Uber', 'Airbnb',
             'شركة الاتصالات السعودية', 'مجموعة stc', 'شركة زين', 'شركة دو', 'شركة اتصالات مصر',
            'شركة أورانج مصر', 'شركة موبايلي', 'شركة كريم', 'شركة سوق دوت كوم', 'شركة جوميا'
        ];

        $logos = [
               'facebook.png', 'amazon.png', 'apple.png', 'microsoft.png',
            'netflix.png', 'twitter.png', 'linkedin.png', 'uber.png', 'airbnb.png',
             'stc.png', 'stc_group.png', 'zain.png', 'du.png', 'etisalat_misr.png',
            'orange_misr.png', 'mobily.png', 'careem.png', 'souq.png', 'jumia.png'
        ];

        $emails = [
              'contact@facebook.com', 'contact@amazon.com', 'contact@apple.com', 'contact@microsoft.com',
            'contact@netflix.com', 'contact@twitter.com', 'contact@linkedin.com', 'contact@uber.com', 'contact@airbnb.com',
             'contact@stc.com.sa', 'contact@stcgroup.com', 'contact@zain.com', 'contact@du.ae', 'contact@etisalat.eg',
            'contact@orange.eg', 'contact@mobily.com.sa', 'contact@careem.com', 'contact@souq.com', 'contact@jumia.com'
        ];

        $locations = [
              'Menlo Park, CA', 'Seattle, WA', 'Cupertino, CA', 'Redmond, WA',
            'Los Gatos, CA', 'San Francisco, CA', 'Sunnyvale, CA', 'San Francisco, CA', 'San Francisco, CA',
             'الرياض، السعودية', 'الرياض، السعودية', 'الرياض، السعودية', 'دبي، الإمارات', 'القاهرة، مصر',
            'القاهرة، مصر', 'الرياض، السعودية', 'دبي، الإمارات', 'دبي، الإمارات', 'القاهرة، مصر'
        ];

        $websites = [
             'https://www.facebook.com', 'https://www.amazon.com', 'https://www.apple.com', 'https://www.microsoft.com',
            'https://www.netflix.com', 'https://www.twitter.com', 'https://www.linkedin.com', 'https://www.uber.com', 'https://www.airbnb.com',
            'https://www.stc.com.sa', 'https://www.stcgroup.com', 'https://www.zain.com', 'https://www.du.ae', 'https://www.etisalat.eg',
            'https://www.orange.eg', 'https://www.mobily.com.sa', 'https://www.careem.com', 'https://www.souq.com', 'https://www.jumia.com'
        ];



        $abouts = [

            'Facebook is a social media and social networking service.',
            'Amazon is an e-commerce and cloud computing company.',
            'Apple designs, manufactures, and markets smartphones, personal computers, tablets, wearables, and accessories.',
            'Microsoft develops, manufactures, licenses, supports, and sells computer software, consumer electronics, personal computers, and related services.',
            'Netflix is a streaming service that offers a wide variety of TV shows, movies, anime, documentaries, and more.',
            'Twitter is a social media platform that allows users to send and read short 280-character messages called tweets.',
            'LinkedIn is a business and employment-oriented online service that operates via websites and mobile apps.',
            'Uber is a ride-hailing service that allows users to book a car and driver to transport them in a way similar to a taxi.',
            'Airbnb is an online marketplace for arranging or offering lodging, primarily homestays, or tourism experiences.',
            'شركة الاتصالات السعودية هي الشركة الرائدة في مجال الاتصالات في المملكة العربية السعودية.',
            'مجموعة stc هي مجموعة اتصالات متكاملة تقدم خدمات متنوعة في المملكة العربية السعودية.',
            'شركة زين هي واحدة من أكبر شركات الاتصالات في الشرق الأوسط.',
            'شركة دو تقدم خدمات الاتصالات والإنترنت في دولة الإمارات العربية المتحدة.',
            'شركة اتصالات مصر هي شركة الاتصالات الرائدة في مصر.',
            'شركة أورانج مصر تقدم خدمات الاتصالات والإنترنت في مصر.',
            'شركة موبايلي هي شركة اتصالات سعودية تقدم خدمات الهاتف المحمول.',
            'شركة كريم تقدم خدمات النقل الذكي في الشرق الأوسط.',
            'شركة سوق دوت كوم هي أكبر منصة للتجارة الإلكترونية في الشرق الأوسط.',
            'شركة جوميا هي منصة تجارة إلكترونية رائدة في إفريقيا والشرق الأوسط.'
        ];

        $field_ids = [ 1, 2, 2, 3, 4, 5, 6, 7, 8, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10];

        for ($i = 0; $i < count($names); $i++) {
            DB::table('companies')->insert([
                'name' => $names[$i],
                'logo' => $logos[$i],
                'email' => $emails[$i],
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'location' => $locations[$i],
                'website' => $websites[$i],
                'about' => $abouts[$i],
                'field_id' => $field_ids[$i],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
           DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        }
    }
}
