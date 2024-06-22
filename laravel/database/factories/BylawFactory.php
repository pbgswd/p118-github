<?php

namespace Database\Factories;

use App\Models\Bylaw;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class BylawFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'title' => 'Bylaw '.$this->faker->name().' name',
            'description' => 'Bylaw description '.$this->faker->paragraph(),
            'access_level' => 'members',
            'live' => 1,
            'date' => Carbon::now(),
            'user_id' => \App\Models\User::factory(),
        ];
    }
}
