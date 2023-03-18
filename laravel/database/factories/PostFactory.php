<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Post;

class PostFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Post::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        //todo should user be user with permissions admin_user?
        return [
            'user_id' => \App\Models\User::factory(),
            'title' => $this->faker->sentence,
            'content' => $this->faker->text(),
            'access_level' => 'public',
            'live' => 1,
            'front_page' => $this->faker->boolean,
            'landing_page'=> $this->faker->boolean,
        ];
    }
}
