<?php

namespace Database\Factories;

use App\Models\CommitteePost;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommitteePostFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        //todo post and user has to be associated with committee
        return [
            'user_id' => \App\Models\User::factory(),
            'title' => $this->faker->sentence(),
            'content' => $this->faker->text(),
            'live' => 1,
            'sticky' => 1,
            'allow_comments' => 0,
        ];
    }
}
