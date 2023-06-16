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
            'url' => $this->faker->url,
            'name' => $this->faker->word,
            'file' => 'stored_file_' . $this->faker->md5 .'.jpg',
        ];
    }
}
