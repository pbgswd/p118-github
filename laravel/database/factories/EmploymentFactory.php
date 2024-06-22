<?php

namespace Database\Factories;

use App\Models\Employment;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class EmploymentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'title' => 'Job Posting with '.$this->faker->company(),
            'description' => 'Job posting description '.$this->faker->paragraph(),
            'url' => $this->faker->url(),
            'live' => 1,
            'deadline' => Carbon::now()->addMonths(3),
            'user_id' => \App\Models\User::factory(),
        ];
    }
}
