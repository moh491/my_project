<?php

namespace Database\Seeders;

use App\Models\Application;
use App\Models\CompanyJob;
use App\Models\Freelancer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ApplicationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');


        $jobs = CompanyJob::inRandomOrder()->limit(10)->get();
         $companyId = 1;

         $jobs = CompanyJob::where('company_id', $companyId)->get();

         if ($jobs->isEmpty()) {
            echo "لا توجد وظائف للشركة ذات ID = {$companyId}";
            return;
        }

         $job = $jobs->first();

         $freelancers = Freelancer::inRandomOrder()->limit(10)->get();


         $statuses = ['reviewed', 'accepted', 'rejected', 'pending'];

         foreach ($jobs as $job) {
            Application::create([
                'is_accepted' => rand(0, 1),
                'status' => $statuses[array_rand($statuses)],
                'budget' => rand(1000, 10000),
                'experience_year' => rand(1, 10),
                'file' => 'sample.pdf',
                'job_id' => $job->id,
                'freelancer_id' => 1,
            ]);
        }
        foreach ($freelancers as $freelancer) {
            Application::create([
                'is_accepted' => rand(0, 1),
                'status' => $statuses[array_rand($statuses)],
                'budget' => rand(1000, 10000),
                'experience_year' => rand(1, 10),
                'file' => 'sample.pdf',
                'job_id' => $job->id,
                'freelancer_id' => $freelancer->id,
            ]);
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
