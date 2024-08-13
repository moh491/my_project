<?php

namespace Database\Seeders;

use App\Models\Certification;
use App\Models\Freelancer;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CertificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Certification::truncate();

         $freelancers = Freelancer::all();

         $certificationsByPosition = [
            1 => [
                [
                    'title' => 'Certified Laravel Developer',
                    'start_date' => '2022-01-01',
                    'end_date' => '2022-12-31',
                    'credentials_id' => 'LAR123456',
                    'link' => 'https://certifications.example.com/laravel',
                    'image' => 'certifications/laravel-cert.jpg',
                ],
                [
                    'title' => 'AWS Certified Solutions Architect',
                    'start_date' => '2023-03-01',
                    'end_date' => '2024-03-01',
                    'credentials_id' => 'AWS987654',
                    'link' => 'https://certifications.example.com/aws',
                    'image' => 'certifications/aws-cert.jpg',
                ],
            ],
            2 => [
                [
                    'title' => 'Adobe Certified Expert (ACE) Photoshop',
                    'start_date' => '2021-05-01',
                    'end_date' => '2022-05-01',
                    'credentials_id' => 'ADOBE123456',
                    'link' => 'https://certifications.example.com/photoshop',
                    'image' => 'certifications/photoshop-cert.jpg',
                ],
            ],
            3 => [
                [
                    'title' => 'Certified Flutter Developer',
                    'start_date' => '2020-09-01',
                    'end_date' => '2021-09-01',
                    'credentials_id' => 'FLUT567890',
                    'link' => 'https://certifications.example.com/flutter',
                    'image' => 'certifications/flutter-cert.jpg',
                ],
            ],
            4 => [
                [
                    'title' => 'Google Data Engineer Professional Certificate',
                    'start_date' => '2021-01-01',
                    'end_date' => '2022-01-01',
                    'credentials_id' => 'GOOGDATA123',
                    'link' => 'https://certifications.example.com/data-engineer',
                    'image' => 'certifications/data-engineer-cert.jpg',
                ],
            ],
            6 => [
                [
                    'title' => 'Google UX Design Professional Certificate',
                    'start_date' => '2021-05-01',
                    'end_date' => '2022-05-01',
                    'credentials_id' => 'GOO456789',
                    'link' => 'https://certifications.example.com/google-ux',
                    'image' => 'certifications/google-ux-cert.jpg',
                ],
            ],
            13 => [
                [
                    'title' => 'Cisco Certified Network Associate (CCNA)',
                    'start_date' => '2022-02-01',
                    'end_date' => '2023-02-01',
                    'credentials_id' => 'CISCO123456',
                    'link' => 'https://certifications.example.com/ccna',
                    'image' => 'certifications/ccna-cert.jpg',
                ],
            ],
            8 => [
                [
                    'title' => 'ISTQB Certified Tester',
                    'start_date' => '2022-03-01',
                    'end_date' => '2023-03-01',
                    'credentials_id' => 'ISTQB123456',
                    'link' => 'https://certifications.example.com/istqb',
                    'image' => 'certifications/istqb-cert.jpg',
                ],
            ],
        ];


        foreach ($freelancers as $freelancer) {
            if (isset($certificationsByPosition[$freelancer->position_id])) {
                foreach ($certificationsByPosition[$freelancer->position_id] as $certification) {
                    Certification::create(array_merge($certification, [
                        'freelancer_id' => $freelancer->id,
                    ]));
                }
            }
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
//        Certification::truncate();
//        Certification::create([
//            'title' =>'intro to backend development',
//            'start_date'=>'2024-05-01',
//            'end_date' => "2027-05-01",
//            'credentials_id' => "XSDF3FS",
//            'image' => "Certification/certification.jpg",
//            'freelancer_id'=>1,
//        ]);
//        Certification::create([
//            'title' =>'intro to front development',
//            'start_date'=>'2024-05-01',
//            'end_date' => "2027-05-01",
//            'credentials_id' => "XSDF3FS",
//            'image' => "Certification/certification.jpg",
//            'freelancer_id'=>1,
//        ]);
    }
}
