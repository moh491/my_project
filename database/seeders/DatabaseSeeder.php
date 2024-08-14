<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Offer;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        $this->call([
            FieldSeeder::class,
            FreelancerSeeder::class,
            SkillSeeder::class,
            ProjectOwnerSeeder::class,
            CompanySeeder::class,
            LanguageSeeder::class,
            CertificationSeeder::class,
            EducationSeeder::class,
            PositionSeeder::class,
            ExperiencesSeeder::class,
            PortfolioSeeder::class,
            ProjectSeeder::class,
            ReviewSeeder::class,
            ServiceSeeder::class,
            JobSeeder::class,
            PlanSeeder::class,
            featuresSeeder::class,
            PlanFeaturesSeeder::class,
            TeamSeeder::class,
        ]);
        Offer::factory(5)->create();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
