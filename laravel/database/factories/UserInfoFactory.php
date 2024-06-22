<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class UserInfoFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'user_id' => \App\Models\User::factory(),
            'show_profile' => 1,
            'show_picture' => 0,
            'share_email' => $this->faker->boolean(),
            'share_phone' => $this->faker->boolean(),
            'file_name' => null,
            'image' => null,
            'about' => $this->faker->text(200),
        ];
    }
}
