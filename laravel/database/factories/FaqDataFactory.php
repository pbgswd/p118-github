<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class FaqDataFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'faq_id' => 1,
            'question' => 'Question ' . $this->faker->words(5, true),
            'answer' => 'Answer ' . $this->faker->paragraph,
            'access_level' => 'members',
            'live' => 1,
            'sort_order' => 100,

        ];
    }
}
