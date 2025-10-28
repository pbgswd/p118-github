<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class ContactlistFactory extends Factory
{
    /**
     * Define the model's default state.
     *,
     * @return array<string, mixed>
     */

//\App\Models\Contactlist::factory()->make()

    public function definition(): array
    {
        return [
            'title' => "Employer Contact List",
            'content' => "use this list for several reasons, worksafe, t4, policy, lists etc",
            'live' => 1,
            'access_level' => 'members',
        ];
    }
}
