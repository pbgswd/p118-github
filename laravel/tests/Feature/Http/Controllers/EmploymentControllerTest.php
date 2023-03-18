<?php

namespace Tests\Feature\Http\Controllers;

use Tests\TestCase;

/**
 * @see \App\Http\Controllers\EmploymentController
 */
class EmploymentControllerTest extends TestCase
{
    /**
     * @test
     * @group indexok
     */
    public function index_returns_an_ok_response()
    {
        $employments = \App\Models\Employment::factory()->times(3)->create();
        $response = $this->actingAs($this->user)->get(route('jobs_list'));
        $response->assertOk();
        $response->assertViewIs('employment_list');
        $response->assertViewHas('data');
    }

    /**
     * @test
     */
    public function index_by_year_returns_an_ok_response()
    {
        $employment = \App\Models\Employment::factory()->create();
        $employments = \App\Models\Employment::factory()->times(3)->create();
        $deadline = date_format($employment->deadline, 'Y');
        $response = $this->actingAs($this->user)
            ->get(route('list_jobs_year', ['deadline' => $deadline]));
        $response->assertOk();
        $response->assertViewIs('employment_list');
        $response->assertViewHas('data');
    }

    /**
     * @test
     */
    public function jobs_year_returns_an_ok_response()
    {
        $employment = \App\Models\Employment::factory()->create();
        $employments = \App\Models\Employment::factory()->times(3)->create();
        $deadline = date_format($employment->deadline, 'Y');
        $response = $this->actingAs($this->user)->post(route('jobs_year'), [
            'deadline' => $deadline
        ]);
        $response->assertRedirect(route('list_jobs_year', $deadline));
    }

    /**
     * @test
     */
    public function jobs_year_validates_with_a_form_request()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\EmploymentController::class,
            'jobs_year',
            \App\Http\Requests\Employment\QueryJobYearRequest::class
        );
    }

    /**
     * @test
     */
    public function show_returns_an_ok_response()
    {
        $employment = \App\Models\Employment::factory()->create();
        $response = $this->actingAs($this->user)->get(route('job_view', [$employment]));
        $response->assertOk();
        $response->assertViewIs('employment');
        $response->assertViewHas('data');
    }
}
