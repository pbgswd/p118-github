<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Meeting;

class MeetingFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Meeting::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => 'Meeting title ' . $this->faker->word(),
            'description' => $this->faker->paragraph(),
            'date' => Carbon::now(),
            'live' => 1,
            'user_id' => \App\Models\User::factory(),
        ];
    }
}
