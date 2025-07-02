<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        // todo should user be user with permissions admin_user?
        return [
            //  'user_id' => \App\Models\User::factory(),
            'title' => $this->faker->sentence(),
            'content' => $this->faker->text(),
            'access_level' => 'public',
            'live' => 1,
            'front_page' => $this->faker->boolean(),
            'landing_page' => $this->faker->boolean(),
        ];
    }
}
