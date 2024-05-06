<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Review;
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
            FreelancerSeeder::class,
            ProjectOwnerSeeder::class,
            CompanySeeder::class,
            LanguageSeeder::class,
            SkillSeeder::class,
            CertificationSeeder::class,
            EducationSeeder::class,
            ExperiencesSeeder::class,
            PortfolioSeeder::class,
            ReviewSeeder::class,
            ServiceSeeder::class,
            JobSeeder::class,
            FieldSeeder::class,
            PositionSeeder::class,
            ProjectSeeder::class,

        ]);
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
