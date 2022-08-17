<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Proofreader;
use Illuminate\Support\Carbon;

class ProofreaderFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Proofreader::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {

        return [
            'admin_link' =>  $this->faker->url(),
            'pub_link' =>  $this->faker->url(),
            'title' => $this->faker->sentence,
            'content_type'=> 'Agreement',
            'content_title' => 'Agreements',
            'user_id' => \App\Models\User::factory(),
            'proofread_at' => Carbon::now(),
            'content_updated_at' => Carbon::now(),

        ];
    }
}
