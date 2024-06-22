<?php

namespace Database\Factories;

use App\Models\Committee;
use Illuminate\Database\Eloquent\Factories\Factory;

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
