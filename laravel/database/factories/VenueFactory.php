<?php

namespace Database\Factories;

use App\Models\Venue;
use Illuminate\Database\Eloquent\Factories\Factory;

class VenueFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        $name = $this->faker->company().' hall venue';
        $slug = strtolower($name);

        return [
            'user_id' => \App\Models\User::factory(),
            'name' => $name,
            'description' => $this->faker->text(50),
            'url' => $this->faker->url(),
            'image' => '',
            'file_name' => '',
            'access_level' => 'public',
            'live' => 1,
        ];
    }
}
