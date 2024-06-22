<?php

namespace Database\Factories;

use App\Models\EmailQueue;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\EmailQueue>
 */
class EmailQueueFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = EmailQueue::class;

    public function definition(): array
    {

        $sender = $this->faker->email();

        return [
            'sender' => $sender,
            'recipient' => $this->faker->email(),
            'subject' => $this->faker->words(5, true),
            'message' => $this->faker->paragraph(5),
            'attachments' => null, // should be serialized data $this->faker->word() . time().".pdf",
            'attachments' => null, // should be serialized data $this->faker->word() . time().".pdf",
        ];
    }
}
