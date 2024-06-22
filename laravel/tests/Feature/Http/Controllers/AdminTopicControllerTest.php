<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Topic;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\AdminTopicController
 */
class AdminTopicControllerTest extends TestCase
{
    //

    /**
     * @test
     *
     * @group createok
     */
    public function create_returns_an_ok_response(): void
    {
        $response = $this->actingAs($this->admin_user)
            ->get(route('topic_create'));

        $response->assertOk();
        $response->assertViewIs('admin.topic');
        $response->assertViewHas('data');
    }

    /**
     * @test
     *
     * @group destroyok
     */
    public function destroy_returns_an_ok_response(): void
    {
        $topic = \App\Models\Topic::factory()->create();

        $response = $this->actingAs($this->admin_user)
            ->delete(route('topic_destroy', ['id' => $topic->id]));

        $this->assertModelMissing($topic);
        $response->assertRedirect(route('topics_list'));
    }

    /**
     * @test
     *
     * @group destroyok
     */
    public function destroy_validates_with_a_form_request(): void
    {
        $this->actingAs($this->admin_user)->assertActionUsesFormRequest(
            \App\Http\Controllers\AdminTopicController::class,
            'destroy',
            \App\Http\Requests\Topic\DestroyTopicRequest::class
        );
    }

    /**
     * @test
     *
     * @group editok
     */
    public function edit_returns_an_ok_response(): void
    {
        $topic = \App\Models\Topic::factory()->create();

        $response = $this->actingAs($this->admin_user)
            ->get(route('topic_edit', $topic->slug));

        $response->assertOk();
        $response->assertViewIs('admin.topic');
        $response->assertViewHas('data');
    }

    /**
     * @test
     *
     * @group indexok
     */
    public function index_returns_an_ok_response(): void
    {
        $topics = \App\Models\Topic::factory()->times(3)->create();

        $response = $this->actingAs($this->admin_user)
            ->get(route('topics_list'));

        $response->assertOk();
        $response->assertViewIs('admin.listtopics');
        $response->assertViewHas('data');
    }

    /**
     * @test
     *
     * @group storeok
     */
    public function store_returns_an_ok_response(): void
    {
        $topic = \App\Models\Topic::factory()->make();

        $response = $this->actingAs($this->admin_user)
            ->post('admin/topic/create', [
                'topic' => $topic->toArray(),
            ]);
        // both work
        //$this->assertEquals(Session::get('success'), 'You have saved a new topic');
        $response->assertRedirect(route('topic_edit', [$topic->slug]));
    }

    /**
     * @test
     *
     * @group storeok
     */
    public function store_validates_with_a_form_request(): void
    {
        $this->actingAs($this->admin_user)->assertActionUsesFormRequest(
            \App\Http\Controllers\AdminTopicController::class,
            'store',
            \App\Http\Requests\Topic\StoreTopicRequest::class
        );
    }

    /**
     * @test
     *
     * @group updateok
     */
    public function update_returns_an_ok_response(): void
    {
        $topic = \App\Models\Topic::factory()->create();

        $data = Topic::first();

        $data['name'] = 'update to name '.$data->name;

        $response = $this->actingAs($this->admin_user)
            ->post('admin/topic/'.$topic->slug.'/edit', [
                'topic' => $data->toArray(),
            ]);

        $response->assertRedirect(route('topic_edit', $data->slug));
    }

    /**
     * @test
     *
     * @group updateok
     */
    public function update_validates_with_a_form_request(): void
    {
        $this->actingAs($this->admin_user)->assertActionUsesFormRequest(
            \App\Http\Controllers\AdminTopicController::class,
            'update',
            \App\Http\Requests\Topic\UpdateTopicRequest::class
        );
    }
}
