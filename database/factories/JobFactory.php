<?php

namespace Database\Factories;

use App\Enums\Employment_Type;
use App\Enums\Level;
use App\Enums\Location_Type;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Job>
 */
class JobFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'location_type' => $this->faker->randomElement(Location_Type::getValues()),
            'employment_type' => $this->faker->randomElement(Employment_Type::getValues()),
            'level' => $this->faker->randomElement(Level::getValues()),
            'description' => $this->faker->paragraph,
            'min_salary' => $this->faker->randomFloat(2, 1000, 10000),
            'max_salary' => $this->faker->randomFloat(2, 10000, 50000),
//            'responsibilities' => [1,2,3],
//            'requirements' => json_encode([1,2,3]),
            'position_id' => random_int(1, 3),
            'company_id' => random_int(1, 3),
        ];
    }
}
