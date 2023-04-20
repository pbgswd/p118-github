<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\CommitteePost;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\CommitteePostController
 */
class CommitteePostControllerTest extends TestCase
{


    /**
     * @test
     * @group createok
     */
    public function create_returns_an_ok_response()
    {
        $response = $this->actingAs($this->committee_admin_user)
            ->get(route('committee_add_public_post', [$this->committee]));

        $response->assertOk();
        $response->assertViewIs('committee_post_form');
        $response->assertViewHas('data');

    }

    /**
     * @test
     * @group destroyok
     */
    public function destroy_returns_an_ok_response()
    {
        $post = CommitteePost::find($this->committeePost);
        //dd($post);

        $response = $this->actingAs($this->committee_admin_user)
            ->delete(route('public_committee_post_destroy', [$this->committee, $post]),
            ['id' => $post->id]
            );

        $response->assertRedirect(route('committee', $this->committee->slug));
        $this->assertModelMissing($this->committeePost);
    }

    /**
     * @test
     * @group destroyok
     */
    public function destroy_validates_with_a_form_request()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\CommitteePostController::class,
            'destroy',
            \App\Http\Requests\CommitteePost\DestroyCommitteePostRequest::class
        );
    }

    /**
     * @test
     * @group editok
     */
    public function edit_returns_an_ok_response()
    {
        $response = $this->actingAs($this->committee_admin_user)
            ->get(route('committee_post_edit_form', [$this->committee, $this->committeePost]));

        $response->assertOk();
        $response->assertViewIs('committee_post_form');
    }

    /**
     * @test
     * @group showok
     */
    public function show_returns_an_ok_response()
    {
        $response = $this->actingAs($this->committee_admin_user)
            ->get(route('public_committee_post_show', [$this->committee, $this->committeePost]));

        $response->assertOk();
        $response->assertViewIs('committee_post');
        $response->assertViewHas('data');
    }

    /**
     * @test
     * @group storeok
     */
    public function store_returns_an_ok_response()
    {
        //$post = CommitteePost::factory()->make();

        $post = CommitteePost::factory()
            ->make(['committee_id' => $this->committee->id, 'user_id' => $this->user->id]);

        $response = $this->actingAs($this->committee_admin_user)
            ->post(route('committee_store_public_post', $this->committee->slug), [
            'post' => $post->toArray()
        ]);

        $response->assertRedirect(route('committee_post_edit_form', [$this->committee->slug, $post->value('slug')]));
    }

    /**
     * @test
     * @group storeok
     */
    public function store_validates_with_a_form_request()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\CommitteePostController::class,
            'store',
            \App\Http\Requests\CommitteePost\StoreCommitteePostRequest::class
        );
    }

    /**
     * @test
     * @group updateok
     */
    public function update_returns_an_ok_response()
    {

        $post = CommitteePost::find($this->committeePost);
        $post['access_level'] = 'public';
        $response = $this->actingAs($this->admin_user)
            ->post(route('committee_update_public_post', [$this->committee->slug, $post[0]['slug']]), [
                'post' => $post[0]
        ]);
        dump($post[0]['slug']);
        $post = CommitteePost::latest()->first();
        dump($post['slug']);
        dump($this->committee->slug);

        $response->assertRedirect(route('committee_post_edit_form', [$this->committee->slug, $post['slug']])
        );
    }

    /**
     * @test
     * @group updateok
     */
    public function update_validates_with_a_form_request()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\CommitteePostController::class,
            'update',
            \App\Http\Requests\CommitteePost\UpdateCommitteePostRequest::class
        );
    }
}
