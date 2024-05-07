<?php

namespace Database\Seeders;

use App\Models\Experience;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ExperiencesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Experience::truncate();
        Experience::create([
            'company_name'=>'OurCompany',
            'employment_type'=>1,
            'location_type'=>1,
            'location'=>'Damascus, Syria',
            'start_date'=>'2024-05-01',
            'end_date'=>'2025-05-03',
            'freelancer_id'=>1,
            'description'=>'Frontend developers specialize in building engaging user interfaces (UIs) and interactive web applications that users interact with directly in their web browsers. They focus on the presentation layer of web development, translating designs into functional and responsive interfaces using HTML, CSS, and JavaScript.',
            'position_id'=>1,
            'company_id'=>1,
        ]);
        Experience::create([
            'company_name'=>'Meta',
            'employment_type'=>2,
            'location_type'=>2,
            'location'=>'Damascus, Syria',
            'start_date'=>'2024-05-01',
            'end_date'=>'2025-05-03',
            'freelancer_id'=>1,
            'description'=>'As a backend developer, individuals specialize in designing, implementing, and maintaining the server-side logic of web applications and software systems. They play a crucial role in building the foundation and architecture that supports the frontend user interface and ensures smooth functionality of the entire application.',
            'position_id'=>2,
            'company_id'=>2,
        ]);
    }
}
