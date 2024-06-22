<?php

namespace Database\Factories;

use App\Models\Executive;
use Illuminate\Database\Eloquent\Factories\Factory;

class ExecutiveFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => 'executive title '.$this->faker->jobTitle(),
            'email' => $this->faker->email(),
        ];
    }
}
