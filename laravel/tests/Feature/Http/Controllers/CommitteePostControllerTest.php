<?php

namespace Tests\Feature\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\CommitteePostController
 */
class CommitteePostControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function create_returns_an_ok_response()
    {
        $this->markTestIncomplete( __FUNCTION__ .' has issues.');

        $committee = \App\Models\Committee::factory()->create();
        $user = \App\Models\User::factory()->create();

        $response = $this->actingAs($user)->get(route('committee_add_public_post', [$committee]));

        $response->assertOk();
        $response->assertViewIs('committee_post_form');
        $response->assertViewHas('data');

        // TODO: perform additional assertions
    }

    /**
     * @test
     */
    public function destroy_returns_an_ok_response()
    {
        $this->markTestIncomplete( __FUNCTION__ .' has issues.');

        $committee = \App\Models\Committee::factory()->create();
        $committeePost = \App\Models\CommitteePost::factory()->create();
        $user = \App\Models\User::factory()->create();

        $response = $this->actingAs($user)->delete(route('public_committee_post_destroy', [$committee, $committeePost]));

        $response->assertRedirect(route('committee', $committee->slug));
        $this->assertModelMissing($committeePost);

        // TODO: perform additional assertions
    }

    /**
     * @test
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
     */
    public function edit_returns_an_ok_response()
    {
        $this->markTestIncomplete( __FUNCTION__ .' has issues.');

        $committee = \App\Models\Committee::factory()->create();
        $committeePost = \App\Models\CommitteePost::factory()->create();
        $user = \App\Models\User::factory()->create();

        $response = $this->actingAs($user)->get(route('committee_post_edit_form', [$committee, $committeePost]));

        $response->assertOk();
        $response->assertViewIs('committee_post_form');

        // TODO: perform additional assertions
    }

    /**
     * @test
     */
    public function show_returns_an_ok_response()
    {
        $this->markTestIncomplete( __FUNCTION__ .' has issues.');

        $committee = \App\Models\Committee::factory()->create();
        $committeePost = \App\Models\CommitteePost::factory()->create();
        $user = \App\Models\User::factory()->create();

        $response = $this->actingAs($user)->get(route('public_committee_post_show', [$committee, $committeePost]));

        $response->assertOk();
        $response->assertViewIs('committee_post');
        $response->assertViewHas('data');

        // TODO: perform additional assertions
    }

    /**
     * @test
     */
    public function store_returns_an_ok_response()
    {
        $this->markTestIncomplete( __FUNCTION__ .' has issues.');

        $committee = \App\Models\Committee::factory()->create();
        $user = \App\Models\User::factory()->create();

        $response = $this->actingAs($user)->post('committee/{committee}/post/create', [
            // TODO: send request data
        ]);

        $response->assertRedirect(route('committee_post_edit_form', [$committee->slug, $post->slug]));

        // TODO: perform additional assertions
    }

    /**
     * @test
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
     */
    public function update_returns_an_ok_response()
    {
        $this->markTestIncomplete( __FUNCTION__ .' has issues.');

        $committee = \App\Models\Committee::factory()->create();
        $committeePost = \App\Models\CommitteePost::factory()->create();
        $user = \App\Models\User::factory()->create();

        $response = $this->actingAs($user)->post('committee/{committee}/post/{any_committee_post}/edit', [
            // TODO: send request data
        ]);

        $response->assertRedirect(route('committee_post_edit_form', [$committee->slug, $committeePost->slug]));

        // TODO: perform additional assertions
    }

    /**
     * @test
     */
    public function update_validates_with_a_form_request()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\CommitteePostController::class,
            'update',
            \App\Http\Requests\CommitteePost\UpdateCommitteePostRequest::class
        );
    }

    // test cases...
}
