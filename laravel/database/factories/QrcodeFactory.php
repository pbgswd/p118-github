<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Qrcode>
 */
class QrcodeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'user_id' => \App\Models\User::factory(),
            'qrdata' => $this->faker->url,
            'qrtype' => 'url',
            'name' => $this->faker->sentence(3),
            'file' => 'stored_file_' . $this->faker->md5 .'.png',
        ];
    }
}
