<?php

namespace Tests\Feature\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\MeetingController
 */
class MeetingControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function index_returns_an_ok_response()
    {
        $this->markTestIncomplete( __FUNCTION__ .' has issues.');

        $meetings = \App\Models\Meeting::factory()->times(3)->create();
        $user = \App\Models\User::factory()->create();

        $response = $this->actingAs($user)->get(route('list_meetings'));

        $response->assertOk();
        $response->assertViewIs('list_meetings_minutes');
        $response->assertViewHas('data');

        // TODO: perform additional assertions
    }

    /**
     * @test
     */
    public function index_by_year_returns_an_ok_response()
    {
        $this->markTestIncomplete( __FUNCTION__ .' has issues.');

        $meeting = \App\Models\Meeting::factory()->create();
        $meetings = \App\Models\Meeting::factory()->times(3)->create();
        $user = \App\Models\User::factory()->create();

        $response = $this->actingAs($user)->get(route('list_meetings_year', ['year' => $meeting->year]));

        $response->assertOk();
        $response->assertViewIs('list_meetings_minutes');
        $response->assertViewHas('data');

        // TODO: perform additional assertions
    }

    /**
     * @test
     */
    public function post_year_returns_an_ok_response()
    {
        $this->markTestIncomplete( __FUNCTION__ .' has issues.');

        $user = \App\Models\User::factory()->create();

        $response = $this->actingAs($user)->post(route('post_year'), [
            // TODO: send request data
        ]);

        $response->assertRedirect(route('list_meetings_year', $request->year));

        // TODO: perform additional assertions
    }

    /**
     * @test
     */
    public function post_year_validates_with_a_form_request()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\MeetingController::class,
            'post_year',
            \App\Http\Requests\Meetings\QueryMeetingYearRequest::class
        );
    }

    /**
     * @test
     */
    public function show_returns_an_ok_response()
    {
        $this->markTestIncomplete( __FUNCTION__ .' has issues.');

        $meeting = \App\Models\Meeting::factory()->create();
        $user = \App\Models\User::factory()->create();

        $response = $this->actingAs($user)->get(route('meeting', [$meeting]));

        $response->assertOk();
        $response->assertViewIs('meeting');
        $response->assertViewHas('data');

        // TODO: perform additional assertions
    }

    // test cases...
}
