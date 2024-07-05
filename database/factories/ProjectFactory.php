<?php

namespace Database\Factories;

use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProjectFactory extends Factory
{
    protected $model = Project::class;

    public function definition(): array
    {
        $array = [
            "Proven experience as a Front-end Developer or similar role",
            'Strong proficiency in HTML, CSS, and JavaScript',
            'Experience with front-end frameworks and libraries (e.g., React, Angular, Vue.js)',
            'Familiarity with RESTful APIs and asynchronous request handling',
            'Solid understanding of responsive design principles and mobile-first approach',
            'Experience with version control systems (e.g., GitExcellent problem-solving skills and attention to data'
        ];
        return [
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'min_budget' => $this->faker->numberBetween(100, 500),
            'max_budget' => $this->faker->numberBetween(200, 1000),
            'status' => $this->faker->numberBetween(1, 4),
            'project_owner_id' => $this->faker->numberBetween(1, 2),
            'field_id' => $this->faker->numberBetween(1, 3),
            'worker_type' => $this->faker->randomElement(['App\\Models\\Freelancer', 'App\\Models\\Employee']),
            'worker_id' => $this->faker->numberBetween(1, 1),
            'duration' => $this->faker->numberBetween(1, 30),
            'ideal_skills' => json_encode($array),
        ];
    }
}
