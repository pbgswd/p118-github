<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Memoriam;
use Illuminate\Support\Carbon;

class MemoriamFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Memoriam::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
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
