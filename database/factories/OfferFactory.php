<?php

namespace Database\Factories;

use App\Models\Freelancer;
use App\Models\Offer;
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
        $freelancer = Auth::guard('Freelancer')->user();

        return [
            'duration' => $this->faker->numberBetween(1, 30),
            'budget' => $this->faker->randomFloat(2, 100, 10000),
            'description' => $this->faker->paragraph,
            'files' => $this->faker->randomElement([null, 'file1.txt', 'file2.txt']),
            'project_id' => $this->faker->numberBetween(1, 4),
            'worker_type' => $freelancer instanceof Freelancer ? $freelancer->getMorphClass() : null,
            'worker_id' => $freelancer instanceof Freelancer ? $freelancer->id : null,
        ];

    }
}
