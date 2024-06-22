<?php

namespace Database\Factories;

use App\Models\InviteUser;
use Illuminate\Database\Eloquent\Factories\Factory;

class InviteUserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {

        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'password' => 'password$2y$10$92IXUN', // password
            'membership_type' => 'Member',
            'role' => 'member',
            'user_id' => 1,
        ];
    }
}
