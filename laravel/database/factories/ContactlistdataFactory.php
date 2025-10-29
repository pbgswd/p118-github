<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Contactlistdata>
 */
class ContactlistdataFactory extends Factory
{
    //  \App\Models\Contactlistdata::factory()->make()
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name() . ' theatre co',
            'addr1' => 1111,
            'addr2' => fake()->streetAddress(),
            'city' => fake()->city,
            'province' => 'BC',
            'country'  => fake()->country,
            'postal_code' => fake()->postcode,
            'website' => fake()->url,
            'email' => fake()->email,
            'contact' => fake()->name,
            'phone' => fake()->phoneNumber,
            'notes' => fake()->text(200),
            'access_level' => 'members',
            'live' => 1,
        ];
    }
}
