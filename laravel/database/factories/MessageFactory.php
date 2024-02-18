<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Message>
 */
class MessageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */



    public function definition()
    {
        $subject = 'message ' . $this->faker->sentence(4);
        $priority = ['regular', 'now'];
        shuffle($priority);
        return [
            'subject' => $subject,
            'slug' => \Illuminate\Support\Str::slug($subject),
            'content' => 'content ' . $this->faker->paragraphs(4, true),
            'user_id' => 1,
            'priority' => $priority[0],
            'sent' => $this->faker->boolean(),
        ];
    }
}
