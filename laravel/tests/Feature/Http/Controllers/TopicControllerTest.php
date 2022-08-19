<?php

namespace Tests\Feature\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\TopicController
 */
class TopicControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function list_returns_an_ok_response()
    {
       // $this->markTestIncomplete( __FUNCTION__ .' has issues.');

        $topics = \App\Models\Topic::factory()->times(3)->create();

        $response = $this->get(route('topics'));

        $response->assertOk();
        $response->assertViewIs('topics');
        $response->assertViewHas('data');


    }

    /**
     * @test
     */
    public function show_returns_an_ok_response()
    {
        $this->markTestIncomplete( __FUNCTION__ .' has issues.');

        $topic = \App\Models\Topic::factory()->create();

        $response = $this->get(route('topic_show', [$topic]));

        $response->assertOk();
        $response->assertRedirect(route('topic_show', [$topic->slug]));
        //$response->assertViewIs('auth.login');


    }


}
