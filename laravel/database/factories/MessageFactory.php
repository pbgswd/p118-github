<?php

namespace Database\Factories;

use App\Models\Message;
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
    public function definition(): array
    {
        $subject = 'message '.$this->faker->sentence(4);
        $slug = Str::slug($subject);

        return [
            'source_url' => $this->faker->url(),
            'section' => 'model',
            'category' => 'message',
            'subject' => $subject,
            'slug' => $slug,
            'content' => 'content '.$this->faker->paragraphs(4, true),
            'user_id' => 1,
            'count' => 0,
            'state' => 'not_sent',
        ];
    }

}
