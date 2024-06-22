<?php

namespace Tests\Feature\Http\Controllers;

use Tests\TestCase;

/**
 * @see \App\Http\Controllers\PostController
 */
class PostControllerTest extends TestCase
{
    /**
     * @test
     */
    public function list_returns_an_ok_response(): void
    {
        // $this->markTestIncomplete( __FUNCTION__ .' has issues.');

        $posts = \App\Models\Post::factory()->times(3)->create();

        $response = $this->get(route('posts'));

        $response->assertOk();
        $response->assertViewIs('posts');
        $response->assertViewHas('data');

    }

    /**
     * @test
     */
    public function show_returns_an_ok_response(): void
    {
        $post = \App\Models\Post::factory()->create();
        $response = $this->get(route('post_show', [$post]));
        $response->assertOk();
        $response->assertViewIs('post');
        $response->assertViewHas('data');
    }
}
