<?php

namespace Database\Seeders;

use App\Models\Certification;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CertificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Certification::truncate();
        Certification::create([
            'title' =>'intro to backend development',
            'start_date'=>'2024-05-01',
            'end_date' => "2027-05-01",
            'link' => "link to certificate",
            'credentials_id' => "XSDF3FS",
            'image' => "link to image",
            'freelancer_id'=>1,
        ]);
        Certification::create([
            'title' =>'intro to front development',
            'start_date'=>'2024-05-01',
            'end_date' => "2027-05-01",
            'link' => "link to certificate",
            'credentials_id' => "XSDF3FS",
            'image' => "link to image",
            'freelancer_id'=>1,
        ]);
    }
}
