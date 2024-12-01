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
            'subject' => $subject,
            'slug' => $slug,
            'content' => 'content ' . $this->faker->paragraphs(4, true),
            'user_id' => 1,
        ];
    }

    //todo make message_cagtegories data for messages

    //todo make user message_selections data

}
