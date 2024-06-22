<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PageFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        $title = $this->faker->sentence();

        return [
            'user_id' => \App\Models\User::factory(),
            'title' => $title,
            'slug' => Str::slug($title),
            'content' => $this->faker->text(200),
            'live' => 1,
            'front_page' => $this->faker->boolean(),
            'landing_page' => $this->faker->boolean(),
            'access_level' => 'public',
        ];
    }
}
