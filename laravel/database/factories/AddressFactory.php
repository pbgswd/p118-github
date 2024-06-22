<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class AddressFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'unit' => $this->faker->randomElement([$this->faker->numberBetween(1, 20), ' ']),
            'street' => $this->faker->streetName(),
            'city' => $this->faker->city(),
            'province' => $this->faker->state(),
            'postal_code' => $this->faker->postcode(),
            'country' => $this->faker->country(),
            //'user_id' => \App\Models\User::factory(),
        ];
    }
}
