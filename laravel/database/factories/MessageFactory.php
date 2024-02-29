<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

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
        $slug = Str::slug($subject);
        return [
            'subject' => $subject,
            'slug' => $slug,
            'content' => 'content ' . $this->faker->paragraphs(4, true),
            'type' => 'Message',
            'name' => 'message',
            'url' => env('APP_URL'). '/messages/'. $slug,
            'user_id' => 1,

            'priority' => $priority[0],
            'sent' => $this->faker->boolean(),
        ];
    }
}
