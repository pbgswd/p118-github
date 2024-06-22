<?php

namespace Database\Factories;

use App\Models\Address;
use App\Models\Membership;
use App\Models\PhoneNumber;
use App\Models\User;
use App\Models\UserInfo;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class MeetingFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        $this->user = User::factory()
            ->has(UserInfo::factory(), 'user_info')
            ->has(PhoneNumber::factory(), 'phone_number')
            ->has(Membership::factory(), 'membership')
            ->has(Address::factory(), 'address')
            ->create();
        $this->user->assignRole('member');

        return [
            'title' => 'Meeting title '.$this->faker->word(),
            'description' => $this->faker->paragraph(),
            'date' => Carbon::now(),
            'live' => 1,
            'user_id' => $this->user->id,
        ];
    }
}
