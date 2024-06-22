<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ExecutiveFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'title' => 'executive title '.$this->faker->jobTitle(),
            'email' => $this->faker->email(),
        ];
    }
}
