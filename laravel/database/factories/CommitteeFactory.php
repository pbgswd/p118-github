<?php

namespace Database\Factories;

use App\Models\Membership;
use App\Models\PhoneNumber;
use App\Models\User;
use App\Models\UserInfo;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Committee;


class CommitteeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Committee::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): Array
    {

        $this->committee_admin_user = User::factory()
            ->has(UserInfo::factory(), 'user_info')
            ->has(PhoneNumber::factory(), 'phone_number')
            ->has(Membership::factory(),'membership')
            ->create();

        $this->committee_admin_user->assignRole(['super-admin', 'member', 'committee']);

        /// \App\Models\User::factory()
        return [
            'user_id' => $this->committee_admin_user->id,
           // 'user_id' => $this->admin_user->id,
            'name' => 'Committee Name ' . $this->faker->name(),
            'description' => 'Committee description ' . $this->faker->paragraph(),
            'file_name' => null,
            'image' => null,
            'email' => $this->faker->email(),
            'live' => $this->faker->boolean(),
        ];
    }
}
