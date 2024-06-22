<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CommitteeFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'name' => 'Committee Name '.$this->faker->name(),
            'description' => 'Committee description '.$this->faker->paragraph(),
            'file_name' => null,
            'image' => null,
            'email' => $this->faker->email(),
            'live' => 1,
        ];
    }
}
