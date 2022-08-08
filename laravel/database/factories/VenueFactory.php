<?php

namespace Database\Factories;

use App\Models\Venue;
use Illuminate\Database\Eloquent\Factories\Factory;

class VenueFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Venue::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $name = $this->faker->company().' hall';
        $slug = strtolower($name);

        return [
            'user_id' => \App\Models\User::factory(),
            'name' => $name,
            'slug' => $slug,
            'description' => $this->faker->text(50),
            'image' => strtolower($this->faker->text(5)).'.jpg',
            'access_level' => 'public',
            'live' => 1,
        ];
    }
}
