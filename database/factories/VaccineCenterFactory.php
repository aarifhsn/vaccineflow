<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\VaccineCenter>
 */
class VaccineCenterFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $centers = ['Hospital', 'Medical Center', 'Clinic', 'Healthcare Center', 'Health Institute', 'Wellness Center', 'Medical Group', 'Health Systems', 'Care Center', 'Health Clinic'];

        return [
            'name' => fake()->company.' '.fake()->randomElement($centers),
            'location' => fake()->address(),
            'daily_capacity' => fake()->numberBetween(2, 10),
        ];
    }
}
