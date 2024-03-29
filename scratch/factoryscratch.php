<?php

use App\Models\MessageMetaData;

$message = Message::factory()->hasMessageMeta(['source_id' => $message->id])->hasMessageSending()->create();


    $user = User::factory()
        ->has(
            Post::factory()
                ->count(3)
                ->state(function (array $attributes, User $user) {
                    return ['user_type' => $user->type];
                })
        )
        ->create();


$message = Message::factory()
    ->has(MessageMetaData::factory()
        ->state(function (array $attributes, Message $message) {
            return ['source_id' => $message->id,
                'source_slug' => $message->slug,
                'source_url' => '/messages/'.$message->slug];
        }), 'messageMeta')
    ->hasMessageSending()
    ->create();





$message = Message::factory()->has(MessageMetaData::factory()->state(function (array $attributes, Message $message) { return ['source_id' => $message->id, 'source_slug' => $message->slug, 'source_url' => '/messages/'.$message->slug]; } ), 'messageMeta')->hasMessageSending()->create();


MessageMeta(['source_id' => $message->id])->hasMessageSending()->create();