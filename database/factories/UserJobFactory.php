<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UserJobs>
 */
class UserJobFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'job_name' => $this->faker->title(),
            'job_description' => $this->faker->text(),
            'user_id' => $this->faker->unique()->numberBetween(1, 50),
            'expert_id' => $this->faker->unique()->numberBetween(2, 500),
            'status_id' =>  $this->faker->numberBetween(1, 4),
            'started' => $this->faker->date(),
            'end' => $this->faker->date(),
            'price' => strval($this->faker->randomFloat(2, 5, 999)),
        ];
    }
}
