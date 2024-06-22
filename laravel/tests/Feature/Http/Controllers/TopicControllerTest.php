<?php

namespace Tests\Feature\Http\Controllers;

use Tests\TestCase;

/**
 * @see \App\Http\Controllers\TopicController
 */
class TopicControllerTest extends TestCase
{
    /**
     * @test
     */
    public function list_returns_an_ok_response(): void
    {
        $topics = \App\Models\Topic::factory()->times(3)->create();
        $response = $this->get(route('topics'));
        $response->assertOk();
        $response->assertViewIs('topics');
        $response->assertViewHas('data');
    }

    /**
     * @test
     *
     * @showok
     */
    public function show_returns_an_ok_response(): void
    {
        $topic = \App\Models\Topic::factory()->create();
        $response = $this->get(route('topic_show', [$topic]));
        $response->assertOk();
        $response->assertViewIs('topic');
        $response->assertViewHas('data');
    }
}
