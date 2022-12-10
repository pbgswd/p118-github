<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Committee;
use function Aws\boolean_value;

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
            'user_id' => \App\Models\User::factory(),
            'name' => 'Committee ' . $this->faker->name(),
            'description' => 'Committee description' . $this->faker->paragraph(),
            'file_name' => null,
            'image' => null,
            'email' => $this->faker->email(),
            'live' => $this->faker->boolean(),
        ];
    }
}
