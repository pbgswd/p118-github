<?php

namespace Tests\Feature\Http\Controllers;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\MeetingController
 */
class MeetingControllerTest extends TestCase
{
    /**
     * @test
     */
    public function index_returns_an_ok_response()
    {
        $meetings = \App\Models\Meeting::factory()->times(3)->create();
        $response = $this->actingAs($this->user)->get(route('list_meetings'));
        $response->assertOk();
        $response->assertViewIs('list_meetings_minutes');
        $response->assertViewHas('data');
    }

    /**
     * @test
     * @indexyearok
     */
    public function index_by_year_returns_an_ok_response()
    {
        $meeting = \App\Models\Meeting::factory()->create();
        $meetings = \App\Models\Meeting::factory()->times(3)->create();
        $response = $this->actingAs($this->user)->get(route('list_meetings_year', ['year' => $meeting->date]));
        $response->assertOk();
        $response->assertViewIs('list_meetings_minutes');
        $response->assertViewHas('data');
    }

    /**
     * @test
     */
    public function post_year_returns_an_ok_response()
    {
        $meeting = \App\Models\Meeting::factory()->create();
        $year = date_format($meeting->date, 'Y');
        $response = $this->actingAs($this->user)->post(route('post_year'), [
            'year' => $year
        ]);
        $response->assertRedirect(route('list_meetings_year', $year));
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
     * @showok
     */
    public function show_returns_an_ok_response()
    {
        $meeting = \App\Models\Meeting::factory()->create();
        $response = $this->actingAs($this->user)->get(route('meeting', [$meeting->id]));
        $response->assertOk();
        $response->assertViewIs('meeting');
        $response->assertViewHas('data');
    }
}
