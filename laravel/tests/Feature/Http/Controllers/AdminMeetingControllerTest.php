<?php

namespace Tests\Feature\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\AdminMeetingController
 */
class AdminMeetingControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function create_returns_an_ok_response()
    {
        $this->markTestIncomplete( __FUNCTION__ .' has issues.');

        $response = $this->get(route('meeting_create'));

        $response->assertOk();
        $response->assertViewIs('admin.meeting');
        $response->assertViewHas('data');

        // TODO: perform additional assertions
    }

    /**
     * @test
     */
    public function destroy_returns_an_ok_response()
    {
        $this->markTestIncomplete( __FUNCTION__ .' has issues.');

        $meeting = \App\Models\Meeting::factory()->create();

        $response = $this->delete(route('meeting_destroy'));

        $response->assertRedirect(route('meetings_list'));
        $this->assertDeleted($meetingDestroy);

        // TODO: perform additional assertions
    }

    /**
     * @test
     */
    public function destroy_validates_with_a_form_request()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\AdminMeetingController::class,
            'destroy',
            \App\Http\Requests\Meetings\DestroyMeetingRequest::class
        );
    }

    /**
     * @test
     */
    public function edit_returns_an_ok_response()
    {
        $this->markTestIncomplete( __FUNCTION__ .' has issues.');

        $meeting = \App\Models\Meeting::factory()->create();

        $response = $this->get(route('meeting_edit', ['any_meeting' => $any_meeting]));

        $response->assertOk();
        $response->assertViewIs('admin.meeting');
        $response->assertViewHas('data');

        // TODO: perform additional assertions
    }

    /**
     * @test
     */
    public function index_returns_an_ok_response()
    {
        $this->markTestIncomplete( __FUNCTION__ .' has issues.');

        $meetings = \App\Models\Meeting::factory()->times(3)->create();

        $response = $this->get(route('meetings_list'));

        $response->assertOk();
        $response->assertViewIs('admin.listmeetings');
        $response->assertViewHas('data');

        // TODO: perform additional assertions
    }

    /**
     * @test
     */
    public function store_returns_an_ok_response()
    {
        $this->markTestIncomplete( __FUNCTION__ .' has issues.');

        $response = $this->post('admin/meeting/create', [
            // TODO: send request data
        ]);

        $response->assertRedirect(route('meeting_edit', [$meeting->id]));

        // TODO: perform additional assertions
    }

    /**
     * @test
     */
    public function store_validates_with_a_form_request()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\AdminMeetingController::class,
            'store',
            \App\Http\Requests\Meetings\StoreMeetingRequest::class
        );
    }

    /**
     * @test
     */
    public function update_returns_an_ok_response()
    {
        $this->markTestIncomplete( __FUNCTION__ .' has issues.');

        $meeting = \App\Models\Meeting::factory()->create();

        $response = $this->post('admin/meeting/{any_meeting}/edit', [
            // TODO: send request data
        ]);

        $response->assertRedirect(route('meeting_edit', [$any_meeting->id]));

        // TODO: perform additional assertions
    }

    /**
     * @test
     */
    public function update_validates_with_a_form_request()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\AdminMeetingController::class,
            'update',
            \App\Http\Requests\Meetings\UpdateMeetingRequest::class
        );
    }

    // test cases...
}
