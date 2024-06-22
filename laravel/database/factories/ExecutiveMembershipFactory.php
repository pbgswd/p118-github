<?php

namespace Database\Factories;

use App\Models\Executive;
use App\Models\ExecutiveMembership;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class ExecutiveMembershipFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        $exec = Executive::factory()->create();
        $user = User::factory()->create();

        return [
            'executive_id' => $exec->id,
            'current' => 1,
            'start_date' => Carbon::now()->subMonth(1),
            'end_date' => Carbon::now()->addyears(2),
            'user_id' => $user->id,
        ];
    }
}
