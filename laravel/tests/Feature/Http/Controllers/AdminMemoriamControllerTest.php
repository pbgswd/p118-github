<?php

namespace Tests\Feature\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\AdminMemoriamController
 */
class AdminMemoriamControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function create_returns_an_ok_response()
    {
        $this->markTestIncomplete( __FUNCTION__ .' has issues.');

        $response = $this->get(route('admin_memoriam_create'));

        $response->assertOk();
        $response->assertViewIs('admin.memoriam');
        $response->assertViewHas('data');

        // TODO: perform additional assertions
    }

    /**
     * @test
     */
    public function destroy_returns_an_ok_response()
    {
        $this->markTestIncomplete( __FUNCTION__ .' has issues.');

        $memoriam = \App\Models\Memoriam::factory()->create();

        $response = $this->delete(route('admin_memoriam_destroy'));

        $response->assertRedirect(route('admin_memoriam_list'));
        $this->assertDeleted($adminMemoriamDestroy);

        // TODO: perform additional assertions
    }

    /**
     * @test
     */
    public function destroy_validates_with_a_form_request()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\AdminMemoriamController::class,
            'destroy',
            \App\Http\Requests\Memoriam\DestroyMemoriamRequest::class
        );
    }

    /**
     * @test
     */
    public function edit_returns_an_ok_response()
    {
        $this->markTestIncomplete( __FUNCTION__ .' has issues.');

        $memoriam = \App\Models\Memoriam::factory()->create();

        $response = $this->get(route('admin_memoriam_edit', ['any_memoriam' => $any_memoriam]));

        $response->assertOk();
        $response->assertViewIs('admin.memoriam');
        $response->assertViewHas('data');

        // TODO: perform additional assertions
    }

    /**
     * @test
     */
    public function index_returns_an_ok_response()
    {
        $this->markTestIncomplete( __FUNCTION__ .' has issues.');

        $memoriams = \App\Models\Memoriam::factory()->times(3)->create();

        $response = $this->get(route('admin_memoriam_list'));

        $response->assertOk();
        $response->assertViewIs('admin.memoriams');
        $response->assertViewHas('data');

        // TODO: perform additional assertions
    }

    /**
     * @test
     */
    public function store_returns_an_ok_response()
    {
        $this->markTestIncomplete( __FUNCTION__ .' has issues.');

        $response = $this->post('admin/memoriam/create', [
            // TODO: send request data
        ]);

        $response->assertRedirect(route('admin_memoriam_edit', [$memoriam->slug]));

        // TODO: perform additional assertions
    }

    /**
     * @test
     */
    public function store_validates_with_a_form_request()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\AdminMemoriamController::class,
            'store',
            \App\Http\Requests\Memoriam\StoreMemoriamRequest::class
        );
    }

    /**
     * @test
     */
    public function update_returns_an_ok_response()
    {
        $this->markTestIncomplete( __FUNCTION__ .' has issues.');

        $memoriam = \App\Models\Memoriam::factory()->create();

        $response = $this->post('admin/memoriam/{any_memoriam}/edit', [
            // TODO: send request data
        ]);

        $response->assertRedirect(route('admin_memoriam_edit', $any_memoriam->slug));

        // TODO: perform additional assertions
    }

    /**
     * @test
     */
    public function update_validates_with_a_form_request()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\AdminMemoriamController::class,
            'update',
            \App\Http\Requests\Memoriam\UpdateMemoriamRequest::class
        );
    }

    // test cases...
}
