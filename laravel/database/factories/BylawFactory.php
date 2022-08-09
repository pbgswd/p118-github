<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Bylaw;

class BylawFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Bylaw::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'title' => 'Bylaw ' . $this->faker->name . ' name',
            'description' => 'Bylaw description ' . $this->faker->paragraph(),
            'access_level' => 'members',
            'live' => 1,
            'date' => Carbon::now(),
            'user_id' => \App\Models\User::factory(),
        ];
    }
}
