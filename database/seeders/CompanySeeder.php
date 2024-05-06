<?php

namespace Database\Seeders;

use App\Models\Company;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Company::truncate();
        Company::create([
            'name'=>'OurCompany',
            'email'=>'Our@gmail.com',
            'logo'=>' ',
            'background_image'=>' ',
            'password'=>'111111',
            'field_id'=>1,
            'about'=>'The description of the company',
            'location'=>'Damascus, Syria',

        ]);
        Company::create([
            'name'=>'Meta',
            'email'=>'Meta@gmail.com',
            'logo'=>' ',
            'background_image'=>' ',
            'password'=>'111111',
            'field_id'=>2,
            'about'=>'The description of the company',
            'location'=>'Damascus, Syria',
        ]);



    }
}
