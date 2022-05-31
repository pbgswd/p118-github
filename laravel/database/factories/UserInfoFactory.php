<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\UserInfo;

class UserInfoFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = UserInfo::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => \App\Models\User::factory(),
            'show_profile' => 1,
            'show_picture' => 0,
            'share_email' => $this->faker->boolean,
            'share_phone' => $this->faker->boolean,
            'file_name' => null,
            'image' => null,
            'about' => $this->faker->text(200),
        ];
    }
}
