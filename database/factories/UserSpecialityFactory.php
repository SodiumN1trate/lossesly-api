<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UserSpeciality>
 */
class UserSpecialityFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'user_id' => $this->faker->unique()->numberBetween(1, 100),
            'speciality_id' => $this->faker->numberBetween(1, 900),
            'experience' => $this->faker->numberBetween(1, 10),
            'price_per_hour' => (string) $this->faker->numberBetween(2, 100),
        ];
    }
}
