<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Meeting;
use Illuminate\Support\Facades\Session;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\Admin\AdminMeetingController
 */
class AdminMeetingControllerTest extends TestCase
{
    //

    /**
     * @test  * @group
     *
     * @group createok
     */
    public function create_returns_an_ok_response(): void
    {
        $response = $this->actingAs($this->admin_user)->get(route('meeting_create'));

        $response->assertOk();
        $response->assertViewIs('admin.meeting');
        $response->assertViewHas('data');
    }

    /**
     * @test
     *
     * @group destroyok
     */
    public function destroy_returns_an_ok_response(): void
    {
        $meeting = \App\Models\Meeting::factory()->create();

        $response = $this->actingAs($this->admin_user)
            ->delete(route('meeting_destroy', ['id' => $meeting]));
        $this->assertModelMissing($meeting);
        $response->assertRedirect(route('meetings_list'));

    }

    /**
     * @test
     *
     * @group destroyok
     */
    public function destroy_validates_with_a_form_request(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\Admin\AdminMeetingController::class,
            'destroy',
            \App\Http\Requests\Meetings\DestroyMeetingRequest::class
        );
    }

    /**
     * @test
     *
     * @group editok
     */
    public function edit_returns_an_ok_response(): void
    {
        $meeting = \App\Models\Meeting::factory()->create();

        $response = $this->actingAs($this->admin_user)
            ->get(route('meeting_edit', ['any_meeting' => $meeting]));

        $response->assertOk();
        $response->assertViewIs('admin.meeting');
        $response->assertViewHas('data');
    }

    /**
     * @test
     *
     * @group indexok
     */
    public function index_returns_an_ok_response(): void
    {
        $meetings = \App\Models\Meeting::factory()->times(3)->create();

        $response = $this->actingAs($this->admin_user)->get(route('meetings_list'));

        $response->assertOk();
        $response->assertViewIs('admin.listmeetings');
        $response->assertViewHas('data');
    }

    /**
     * @test
     *
     * @group storeok
     */
    public function store_returns_an_ok_response(): void
    {
        $meeting = \App\Models\Meeting::factory()->make();

        $response = $this->actingAs($this->admin_user)
            ->post('admin/meeting/create', [
                'meeting' => $meeting->toArray(),
            ]);

        $this->assertEquals(Session::get('success'), 'Meeting saved');
    }

    /**
     * @test
     *
     * @group storeok
     */
    public function store_validates_with_a_form_request(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\Admin\AdminMeetingController::class,
            'store',
            \App\Http\Requests\Meetings\StoreMeetingRequest::class
        );
    }

    /**
     * @test
     *
     * @group updateok
     */
    public function update_returns_an_ok_response(): void
    {
        $meeting = \App\Models\Meeting::factory()->create();
        $data = Meeting::first();

        $data['description'] = 'Updated '.$data->description;

        $response = $this->actingAs($this->admin_user)
            ->post('admin/meeting/'.$meeting->id.'/edit', [
                'meeting' => $data->toArray(),
            ]);
        $response->assertRedirect(route('meeting_edit', ['any_meeting' => $data->id]));

    }

    /**
     * @test
     *
     * @group updateok
     */
    public function update_validates_with_a_form_request(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\Admin\AdminMeetingController::class,
            'update',
            \App\Http\Requests\Meetings\UpdateMeetingRequest::class
        );
    }
}
