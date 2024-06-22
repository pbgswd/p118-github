<?php

namespace Database\Factories;

use App\Models\Feature;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class FeatureFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Feature::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => 'Feature title '.$this->faker->word(),
            'url' => $this->faker->url(),
            'content' => $this->faker->paragraph(),
            'image' => '',
            'file_name' => '',
            'date' => Carbon::now(),
            'live' => 1,
            'access_level' => 'members',
            'front_page' => 0,
            'landing_page' => 1,
        ];
    }
}
