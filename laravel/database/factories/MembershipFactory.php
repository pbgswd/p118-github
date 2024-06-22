<?php

namespace Database\Factories;

use App\Models\Membership;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class MembershipFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'membership_type' => 'Member',
            'membership_date' => $this->faker->date(),
            'membership_expires' => $this->faker->date(),
            'seniority_number' => null,
            'status' => null,
            'admin_notes' => $this->faker->text(20),
        ];
    }
}
