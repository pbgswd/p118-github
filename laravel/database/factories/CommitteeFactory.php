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



        return [
            'name' => 'Committee Name ' . $this->faker->name(),
            'description' => 'Committee description ' . $this->faker->paragraph(),
            'file_name' => null,
            'image' => null,
            'email' => $this->faker->email(),
            'live' => 1,
        ];
    }
}
