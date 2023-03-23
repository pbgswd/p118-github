<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Executive;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\ExecutiveMembership;

class ExecutiveMembershipFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ExecutiveMembership::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $exec = Executive::factory()->create();
        $user = User::factory()->create();

        return [
            'executive_id' => $exec->id,
            'current' => 1,
            'start_date' => Carbon::now()->subMonth(1),
            'end_date' =>  Carbon::now()->addyears(2),
            'user_id' => $user->id,
        ];
    }
}
