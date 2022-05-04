<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Page;

class PageFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Page::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => \App\Models\User::factory(),
            'title' => $this->faker->unique()->sentence,
            'slug' => $this->faker->unique()->slug,
            'live' => $this->faker->boolean,
            'in_menu' => $this->faker->boolean,
            'allow_comments' => $this->faker->boolean,
        ];
    }
}
