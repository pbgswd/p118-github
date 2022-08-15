<?php

namespace Tests\Feature\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\AdminTopicController
 */
class AdminTopicControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function create_returns_an_ok_response()
    {
        $this->markTestIncomplete( __FUNCTION__ .' has issues.');

        $response = $this->get(route('topic_create'));

        $response->assertOk();
        $response->assertViewIs('admin.topic');
        $response->assertViewHas('data');

        // TODO: perform additional assertions
    }

    /**
     * @test
     */
    public function destroy_returns_an_ok_response()
    {
        $this->markTestIncomplete( __FUNCTION__ .' has issues.');

        $topic = \App\Models\Topic::factory()->create();

        $response = $this->delete(route('topic_destroy'));

        $response->assertRedirect(route('topics_list'));
        $this->assertModelMissing($topicDestroy);

        // TODO: perform additional assertions
    }

    /**
     * @test
     */
    public function destroy_validates_with_a_form_request()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\AdminTopicController::class,
            'destroy',
            \App\Http\Requests\Topic\DestroyTopicRequest::class
        );
    }

    /**
     * @test
     */
    public function edit_returns_an_ok_response()
    {
        $this->markTestIncomplete( __FUNCTION__ .' has issues.');

        $topic = \App\Models\Topic::factory()->create();

        $response = $this->get(route('topic_edit', ['any_topic' => $any_topic]));

        $response->assertOk();
        $response->assertViewIs('admin.topic');
        $response->assertViewHas('data');

        // TODO: perform additional assertions
    }

    /**
     * @test
     */
    public function index_returns_an_ok_response()
    {
        $this->markTestIncomplete( __FUNCTION__ .' has issues.');

        $topics = \App\Models\Topic::factory()->times(3)->create();

        $response = $this->get(route('topics_list'));

        $response->assertOk();
        $response->assertViewIs('admin.listtopics');
        $response->assertViewHas('data');

        // TODO: perform additional assertions
    }

    /**
     * @test
     */
    public function store_returns_an_ok_response()
    {
        $this->markTestIncomplete( __FUNCTION__ .' has issues.');

        $response = $this->post('admin/topic/create', [
            // TODO: send request data
        ]);

        $response->assertRedirect(route('topic_edit', [$topic->slug]));

        // TODO: perform additional assertions
    }

    /**
     * @test
     */
    public function store_validates_with_a_form_request()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\AdminTopicController::class,
            'store',
            \App\Http\Requests\Topic\StoreTopicRequest::class
        );
    }

    /**
     * @test
     */
    public function update_returns_an_ok_response()
    {
        $this->markTestIncomplete( __FUNCTION__ .' has issues.');

        $topic = \App\Models\Topic::factory()->create();

        $response = $this->post('admin/topic/{any_topic}/edit', [
            // TODO: send request data
        ]);

        $response->assertRedirect(route('topic_edit', [$any_topic->slug]));

        // TODO: perform additional assertions
    }

    /**
     * @test
     */
    public function update_validates_with_a_form_request()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\AdminTopicController::class,
            'update',
            \App\Http\Requests\Topic\UpdateTopicRequest::class
        );
    }

    // test cases...
}
