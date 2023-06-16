<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Faq>
 */
class FaqFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $topic = 'Topic '.  $this->faker->words(2, true);

        return [
            'user_id' => \App\Models\User::factory(),
            'faq_topic' => $topic,
            'slug' => Str::slug($topic),
            'description'  => 'description '. $this->faker->words(12, true),
            'access_level' => 'public',
            'live' => 1,

            /*******
            'faq_data' =>
                [
                    'faq_id' => 1,
                    'question' => 'Question ' . $this->faker->words(5, true),
                    'answer' => 'Answer ' . $this->faker->paragraph,
                    'access_level' => 'members',
                    'sort_order' => 100
                    'live' => 1,
                ]
*/
            //todo faqs_data table
            //todo faqs_data table has faq_id, question, answer, access_level, live

        ];
    }
}
