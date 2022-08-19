<?php

namespace Tests\Feature\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\EmploymentController
 */
class EmploymentControllerTest extends TestCase
{
    use RefreshDatabase;

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
        $this->markTestIncomplete( __FUNCTION__ .' has issues.');

        $employment = \App\Models\Employment::factory()->create();
        $employments = \App\Models\Employment::factory()->times(3)->create();


        $response = $this->actingAs($user)
            ->get(route('list_jobs_year', ['deadline' => $employment->deadline]));

        $response->assertOk();
        $response->assertViewIs('employment_list');
        $response->assertViewHas('data');


    }

    /**
     * @test
     */
    public function jobs_year_returns_an_ok_response()
    {
        $this->markTestIncomplete( __FUNCTION__ .' has issues.');

        $user = \App\Models\User::factory()->create();

        $response = $this->actingAs($user)->post(route('jobs_year'), [
            // TODO: send request data
        ]);

        $response->assertRedirect(route('list_jobs_year', $request->deadline));


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
        $this->markTestIncomplete( __FUNCTION__ .' has issues.');

        $employment = \App\Models\Employment::factory()->create();
        $user = \App\Models\User::factory()->create();

        $response = $this->actingAs($user)->get(route('job_view', [$employment]));

        $response->assertOk();
        $response->assertViewIs('employment');
        $response->assertViewHas('data');


    }


}
