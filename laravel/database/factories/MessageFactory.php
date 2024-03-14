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



    public function definition(): array
    {
        $subject = 'message ' . $this->faker->sentence(4);
        $priority = ['regular', 'now'];
        shuffle($priority);
        $slug = Str::slug($subject);

        $types = [
            ['type' => 'topic', 'name' => 'safety'],
            ['type' => 'model', 'name' => 'Meeting'],
            ['type' => 'committee', 'name' => 'training-committee'],
        ];

        $selection =  $types[rand(0,2)];
        $sent = ['no', 'send', 'sent'];
        return [
            'subject' => $subject,
            'slug' => $slug,
            'content' => 'content ' . $this->faker->paragraphs(4, true),
            'type' => $selection['type'],
            'name' => $selection['name'],
            'url' => '/messages/'. time(). $slug,
            'source_url' => '',
            'user_id' => 1,
            'priority' => $priority[0],
            'sent' => $sent[rand(0,2)],
        ];
    }
}
