<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Page;
use Illuminate\Support\Str;

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
        $title = $this->faker->sentence;

        return [
            'user_id' => \App\Models\User::factory(),
            'title' => $title,
            'slug' => Str::slug($title),
            'content' => $this->faker->realText(500),
            'live' => $this->faker->boolean,
            'front_page' => $this->faker->boolean,
            'landing_page' => $this->faker->boolean,
            'access_level' => 'members'
        ];
    }
}
