<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

class TopicFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        $title = $this->faker->text(20);

        return [
            'user_id' => \App\Models\User::factory(),
            'name' => $title,
            'slug' => Str::slug($title),
            'description' => $this->faker->text(50),
            'access_level' => 'public',
            'live' => '1',
            'sort_order' => '1000',
            'front_page' => 0,
            'landing_page' => 0,
        ];
    }
}
