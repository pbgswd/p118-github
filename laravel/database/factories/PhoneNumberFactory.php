<?php

namespace Database\Factories;

use App\Models\PhoneNumber;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PhoneNumberFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'phone_number' => $this->faker->phoneNumber(),
            'label' => null,
            'primary' => 1,
        ];
    }
}
