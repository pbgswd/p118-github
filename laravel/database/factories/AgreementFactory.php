<?php

namespace Database\Factories;

use App\Models\Agreement;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class AgreementFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {

        return [
            'user_id' => \App\Models\User::factory(),
            'title' => 'Agreement '.$this->faker->company(),
            'description' => 'Agreement description text '.$this->faker->paragraph(),
            'access_level' => 'members',
            'live' => 1,
            'from' => Carbon::now()->subYears(2),
            'until' => Carbon::now()->addYears(3),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
