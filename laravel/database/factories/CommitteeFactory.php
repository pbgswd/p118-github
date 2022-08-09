<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Committee;

class CommitteeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Committee::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => 'Committee ' . $this->faker->name(),
            'description' => 'Committee description' . $this->faker->paragraph(),
            'file_name' => '',
            'image' => '',
            'email' => $this->faker->email(),
            'live' => 1,
            'user_id' => \App\Models\User::factory(),
        ];
    }
}
