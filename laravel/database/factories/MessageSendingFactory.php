<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MessageSending>
 */
class MessageSendingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $priority = ['normal', 'now'];
        shuffle($priority);

        return [
            'message_id' => '',
            'send_priority' => $priority[0],
            'send_status_now' => 'no',
            'send_status_daily' => 'no',
            'send_status_weekly' => 'no',
        ];
    }
}
