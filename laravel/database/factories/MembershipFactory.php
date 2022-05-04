<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Membership;

class MembershipFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Membership::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => \App\REPLACE_THIS::factory(),
            'membership_date' => $this->faker->date,
            'membership_expires' => $this->faker->date,
            'seniority_number' => $this->faker->randomNumber,
            'status' => $this->faker->word,
        ];
    }
}
