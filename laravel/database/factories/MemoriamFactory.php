<?php

namespace Database\Factories;

use App\Models\Memoriam;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class MemoriamFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'user_id' => \App\Models\User::factory(),
            'title' => $this->faker->name(),
            'content' => $this->faker->paragraph(),
            'live' => 1,
            'file_name' => '',
            'image' => '',
            'date' => Carbon::now(),
        ];
    }
}
