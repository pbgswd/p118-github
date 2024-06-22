<?php

namespace Tests\Feature\Http\Controllers;

use Tests\TestCase;

/**
 * @see \App\Http\Controllers\AdminCommitteePostController
 */
class AdminCommitteePostControllerTest extends TestCase
{
    /**
     * @test
     *
     * @group createok
     */
    public function create_returns_an_ok_response()
    {
        $response = $this->get(route('admin_committee_post', [$this->committee]));
        $response->assertOk();
        $response->assertViewIs('admin.committee_post');
        $response->assertViewHas('data');
    }

    /**
     * @test
     */
    public function destroy_returns_an_ok_response()
    {
        $this->markTestIncomplete(__FUNCTION__.' has issues.');

        $response = $this->delete(route('committee_post_destroy', [$this->committee]));

        $response->assertRedirect(route('committee_posts_list', $this->committee->slug));
        $this->assertModelMissing($this->committee);
    }

    /**
     * @test
     */
    public function destroy_validates_with_a_form_request()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\AdminCommitteePostController::class,
            'destroy',
            \App\Http\Requests\CommitteePost\DestroyCommitteePostRequest::class
        );
    }

    /**
     * @test
     */
    public function edit_returns_an_ok_response()
    {
        $this->markTestIncomplete(__FUNCTION__.' has issues.');

        $committee = \App\Models\Committee::factory()->create();
        $committeePost = \App\Models\CommitteePost::factory()->create();

        $response = $this->get(route('admin_committee_post_edit',
            [$this->committee, 'any_committee_post' => $any_committee_post]));

        $response->assertOk();
        $response->assertViewIs('admin.committee_post');
        $response->assertViewHas('data');
    }

    /**
     * @test
     *
     * @group indexok
     */
    public function index_returns_an_ok_response()
    {
        $response = $this->get(route('committee_posts_list', [$this->committee]));
        $response->assertOk();
        $response->assertViewIs('admin.committee_posts_list');
        $response->assertViewHas('data');
    }

    /**
     * @test
     */
    public function store_returns_an_ok_response()
    {
        $this->markTestIncomplete(__FUNCTION__.' has issues.');

        $response = $this->actingAs($this->admin_user)
            ->post('admin/committee/{committee}/post/create', [
                // TODO: send request data
            ]);

        $response->assertRedirect(route('admin_committee_post_edit', [$this->committee->slug, $post->slug]));
    }

    /**
     * @test
     */
    public function store_validates_with_a_form_request()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\AdminCommitteePostController::class,
            'store',
            \App\Http\Requests\CommitteePost\StoreCommitteePostRequest::class
        );
    }

    /**
     * @test
     */
    public function update_returns_an_ok_response()
    {
        $this->markTestIncomplete(__FUNCTION__.' has issues.');

        $response = $this->actingAs($this->admin_user)
            ->post('admin/committee/{committee}/post/{any_committee_post}/edit', [
                // TODO: send request data
            ]);

        $response->assertRedirect(route('admin_committee_post_edit',
            [$committeePost->committee->slug, $committeePost->slug]));
    }

    /**
     * @test
     */
    public function update_validates_with_a_form_request()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\AdminCommitteePostController::class,
            'update',
            \App\Http\Requests\CommitteePost\UpdateCommitteePostRequest::class
        );
    }
}
