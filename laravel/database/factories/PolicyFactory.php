<?php

namespace Database\Factories;


use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Policy;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class PolicyFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Policy::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->sentence,
            'description' => $this->faker->text(200),
            'live' => $this->faker->boolean,
            'date' => Carbon::now(),
            'user_id' => \App\Models\User::factory(),
        ];
    }
}
