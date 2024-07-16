<?php

namespace Database\Factories;

use App\Models\Freelancer;
use App\Models\Offer;
use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Auth;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Offer>
 */

class OfferFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Offer::class;

    public function definition()
    {
        $projectIds = Project::pluck('id')->toArray();
        $freelancer = Auth::guard('Freelancer')->user();

        return [
            'duration' => $this->faker->numberBetween(1, 30),
            'budget' => $this->faker->randomFloat(2, 100, 10000),
            'description' => $this->faker->paragraph,
            'status' => $this->faker->numberBetween(1, 3),
            'files' => $this->faker->randomElement(['file1.txt', 'file2.txt']),
            'project_id' => $this->faker->randomElement($projectIds),
            'worker_type' => 'App\Models\Freelancer',
            'worker_id' => $freelancer ? $freelancer->id : 1,
        ];
    }
}
