<?php

namespace Database\Factories;

use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProjectFactory extends Factory
{
    protected $model = Project::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'min_budget' => $this->faker->numberBetween(500, 5000),
            'max_budget' => $this->faker->numberBetween(5000, 10000),
            'status' => $this->faker->numberBetween(1, 4),
            'project_owner_id' => $this->faker->numberBetween(1, 2),
            'field_id' => $this->faker->numberBetween(1, 3),
            'worker_type' => $this->faker->randomElement(['App\\Models\\Freelancer', 'App\\Models\\Employee']),
            'worker_id' => $this->faker->numberBetween(1, 1),
            'duration' => $this->faker->numberBetween(1, 12),
        ];
    }
}
