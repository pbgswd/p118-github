<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Employment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Session;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\AdminEmploymentController
 */
class AdminEmploymentControllerTest extends TestCase
{
    //todo test with current schema from sqldump

    /**
     * @test
     * @group createok
     */
    public function create_returns_an_ok_response()
    {
        $response = $this->actingAs($this->admin_user)->get(route('admin_employment_create'));

        $response->assertOk();
        $response->assertViewIs('admin.employment');
        $response->assertViewHas('data');
    }

    /**
     * @test
     * @group destroyok
     */
    public function destroy_returns_an_ok_response()
    {
        $this->markTestIncomplete('has issues');
        $employment = \App\Models\Employment::factory()->create();

        $response = $this->actingAs($this->admin_user)
            ->delete(route('admin_employment_destroy'), ['ids' => $employment->id]);
        $this->assertModelMissing($employment);
        $response->assertRedirect(route('admin_employment_list'));

    }

    /**
     * @test
     * @group destroyok
     */
    public function destroy_validates_with_a_form_request()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\AdminEmploymentController::class,
            'destroy',
            \App\Http\Requests\Employment\DestroyEmploymentRequest::class
        );
    }

    /**
     * @test
     * @group editok
     */
    public function edit_returns_an_ok_response()
    {
        $employment = \App\Models\Employment::factory()->create();

        $response = $this->actingAs($this->admin_user)
            ->get(route('admin_employment_edit', $employment->id));

        $response->assertOk();
        $response->assertViewIs('admin.employment');
        $response->assertViewHas('data');
    }

    /**
     * @test
     * @group indexok
     */
    public function index_returns_an_ok_response()
    {
        $employments = \App\Models\Employment::factory()->times(3)->create();

        $response = $this->actingAs($this->admin_user)
            ->get(route('admin_employment_list'));

        $response->assertOk();
        $response->assertViewIs('admin.employment_list');
        $response->assertViewHas('data');
    }

    /**
     * @test
     * @group storeok
     */
    public function store_returns_an_ok_response()
    {
        $employment = Employment::factory()->make();

        $response = $this->actingAs($this->admin_user)
            ->post('admin/employment/create', [
            'employment' => $employment->toArray()
        ]);

        $this->assertEquals(Session::get('success'), 'employment posting saved');
    }

    /**
     * @test
     * @group storeok
     */
    public function store_validates_with_a_form_request()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\AdminEmploymentController::class,
            'store',
            \App\Http\Requests\Employment\StoreEmploymentRequest::class
        );
    }

    /**
     * @test
     * @group updateok
     */
    public function update_returns_an_ok_response()
    {
        $this->markTestIncomplete('has issues');

        $employment = \App\Models\Employment::factory()->create();

        $job = Employment::first();

        $response = $this->actingAs($this->admin_user)
            ->post('admin/employment/{any_employment}/edit', [
            'employment' => $job->toArray()
        ]);

        $response->assertRedirect(route('admin_employment_edit', ['any_employment' => $job->id]));
    }

    /**
     * @test
     * @group updateok
     */
    public function update_validates_with_a_form_request()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\AdminEmploymentController::class,
            'update',
            \App\Http\Requests\Employment\UpdateEmploymentRequest::class
        );
    }


}
