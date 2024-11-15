<?php

namespace Database\Factories;

use App\Models\Message;
use App\Models\MessageMetaData;
use App\Models\MessageSending;
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
            'subject' => $subject,
            'slug' => $slug,
            'content' => 'content '.$this->faker->paragraphs(4, true),
            'user_id' => 1,
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Message $message) {
            MessageMetaData::factory()->count(1)
                ->state(function (array $attributes) use ($message) {
                    return [
                        'message_id' => $message->id,
                        'source_id' => null,
                        'source_slug' => $message->slug,
                        'source_type' => 'model',
                        'source_type_name' => 'message',
                        'source_url' => null,
                    ];
                })
                ->create();
            MessageSending::factory()->count(1)
                ->state(function (array $attributes) use ($message) {
                    return [
                        'message_id' => $message->id,
                        'send_priority' => 'normal',
                        'send_status_now' => 'send',
                        'send_status_daily' => 'no',
                        'send_status_weekly' => 'no',
                    ];
                })
                ->create();
        });
    }
}
