<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class FeatureFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'title' => 'Feature title '.$this->faker->word(),
            'url' => $this->faker->url(),
            'content' => $this->faker->paragraph(),
            'image' => '',
            'file_name' => '',
            'date' => Carbon::now(),
            'live' => 1,
            'access_level' => 'members',
            'front_page' => 0,
            'landing_page' => 1,
        ];
    }
}
