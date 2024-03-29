<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MessageMetaData>
 */
class MessageMetaDataFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $types = [
            ['type' => 'topic', 'name' => 'safety'],
            ['type' => 'model', 'name' => 'Meeting'],
            ['type' => 'committee', 'name' => 'training-committee'],
        ];

        $selection =  $types[rand(0,2)];
        //$selection['type'] //$selection['name']
        return [
            'message_id' => '',
            'source_id' => 11,
            'source_slug' => '',
            'source_type' => 'model',
            'source_type_name' => 'message',
            'source_url' => '',

        ];
    }
}
