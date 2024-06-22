<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Post;
use Illuminate\Support\Facades\Session;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\AdminPostController
 */
class AdminPostControllerTest extends TestCase
{
    //

    /**
     * @test
     *
     * @group createok
     */
    public function create_returns_an_ok_response()
    {
        $topics = \App\Models\Topic::factory()->create();

        $response = $this->actingAs($this->admin_user)->get(route('post_create'));

        $response->assertOk();
        $response->assertViewIs('admin.post');
        $response->assertViewHas('data');
    }

    /**
     * @test
     *
     * @group destroyok
     */
    public function destroy_returns_an_ok_response()
    {
        $post = \App\Models\Post::factory()->create();

        $response = $this->actingAs($this->admin_user)
            ->delete(route('post_destroy', ['id' => $post->id]));

        $this->assertModelMissing($post);
        $response->assertRedirect(route('posts_list'));
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
     *
     * @group editok
     */
    public function edit_returns_an_ok_response()
    {
        $post = \App\Models\Post::factory()->create();

        $response = $this->actingAs($this->admin_user)
            ->get(route('post_edit', $post->slug));

        $response->assertOk();
        $response->assertViewIs('admin.post');
        $response->assertViewHas('data');
    }

    /**
     * @test
     *
     * @group indexok
     */
    public function index_returns_an_ok_response()
    {
        $posts = \App\Models\Post::factory()->times(3)->create();

        $response = $this->actingAs($this->admin_user)
            ->get(route('posts_list'));

        $response->assertOk();
        $response->assertViewIs('admin.listposts');
        $response->assertViewHas('data');
    }

    /**
     * @test
     *
     * @group storeok
     */
    public function store_returns_an_ok_response()
    {
        $post = \App\Models\Post::factory()->make();
        $response = $this->actingAs($this->admin_user)
            ->post('admin/post/create', [
                'post' => $post->toArray(),
            ]);

        $this->assertEquals(Session::get('success'), 'You have saved a new post');
    }

    /**
     * @test
     *
     * @group storeok
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
     *
     * @group updateok
     */
    public function update_returns_an_ok_response()
    {
        $post = \App\Models\Post::factory()->create();

        $data = Post::first();

        $data->content = 'Content update '.$data->content;

        $response = $this->actingAs($this->admin_user)
            ->post('admin/post/'.$data->slug.'/edit', [
                'post' => $data->toArray(),
            ]);

        $response->assertRedirect(route('post_edit', [$data->slug]));
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
}
