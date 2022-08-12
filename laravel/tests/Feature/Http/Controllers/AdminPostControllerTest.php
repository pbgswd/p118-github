<?php

namespace Tests\Feature\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\AdminPostController
 */
class AdminPostControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function create_returns_an_ok_response()
    {
        $this->markTestIncomplete( __FUNCTION__ .' has issues.');

        $topics = \App\Models\Topic::factory()->times(3)->create();

        $response = $this->get(route('post_create'));

        $response->assertOk();
        $response->assertViewIs('admin.post');
        $response->assertViewHas('data');

        // TODO: perform additional assertions
    }

    /**
     * @test
     */
    public function destroy_returns_an_ok_response()
    {
        $this->markTestIncomplete( __FUNCTION__ .' has issues.');

        $post = \App\Models\Post::factory()->create();

        $response = $this->delete(route('post_destroy'));

        $response->assertRedirect(route('posts_list'));
        $this->assertDeleted($postDestroy);

        // TODO: perform additional assertions
    }

    /**
     * @test
     */
    public function destroy_validates_with_a_form_request()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\AdminPostController::class,
            'destroy',
            \App\Http\Requests\Posts\DestroyPostRequest::class
        );
    }

    /**
     * @test
     */
    public function edit_returns_an_ok_response()
    {
        $this->markTestIncomplete( __FUNCTION__ .' has issues.');

        $post = \App\Models\Post::factory()->create();
        $topics = \App\Models\Topic::factory()->times(3)->create();

        $response = $this->get(route('post_edit', ['any_post' => $any_post]));

        $response->assertOk();
        $response->assertViewIs('admin.post');
        $response->assertViewHas('data');

        // TODO: perform additional assertions
    }

    /**
     * @test
     */
    public function index_returns_an_ok_response()
    {
        $this->markTestIncomplete( __FUNCTION__ .' has issues.');

        $posts = \App\Models\Post::factory()->times(3)->create();

        $response = $this->get(route('posts_list'));

        $response->assertOk();
        $response->assertViewIs('admin.listposts');
        $response->assertViewHas('data');

        // TODO: perform additional assertions
    }

    /**
     * @test
     */
    public function store_returns_an_ok_response()
    {
        $this->markTestIncomplete( __FUNCTION__ .' has issues.');

        $response = $this->post('admin/post/create', [
            // TODO: send request data
        ]);

        $response->assertRedirect(route('post_edit', [$post->slug]));

        // TODO: perform additional assertions
    }

    /**
     * @test
     */
    public function store_validates_with_a_form_request()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\AdminPostController::class,
            'store',
            \App\Http\Requests\Posts\StorePostRequest::class
        );
    }

    /**
     * @test
     */
    public function update_returns_an_ok_response()
    {
        $this->markTestIncomplete( __FUNCTION__ .' has issues.');

        $post = \App\Models\Post::factory()->create();

        $response = $this->post('admin/post/{any_post}/edit', [
            // TODO: send request data
        ]);

        $response->assertRedirect(route('post_edit', [$any_post->slug]));

        // TODO: perform additional assertions
    }

    /**
     * @test
     */
    public function update_validates_with_a_form_request()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\AdminPostController::class,
            'update',
            \App\Http\Requests\Posts\UpdatePostRequest::class
        );
    }

    // test cases...
}
