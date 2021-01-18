<?php

namespace Database\Factories;

use App\Models\Topic;
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
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Topic::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $title = $this->faker->text(20);
        $slug = strtolower($title);

        return [
            'name' => $title,
            'slug' => $slug,
            'description' => $this->faker->text(50),
            'image' => strtolower($this->faker->text(5)).'.jpg',
            'scope' => 'public',
            'live' => 'yes',
            'sort_order' => '1000',
            'in_menu' => 'yes',
            'allow_comments' => 'yes',
        ];
    }
}
