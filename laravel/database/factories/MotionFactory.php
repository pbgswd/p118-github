<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Motion>
 */
class MotionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $ids = [1, 136, 142, 148, 135];
        $types = ['Motion', 'New Business'];

        return [
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'date' => now(),
            'user_id' => $ids[array_rand($ids)],
            'meeting_id' => null,
            'submission_type' => $types[array_rand($types)],
        ];
    }
}
