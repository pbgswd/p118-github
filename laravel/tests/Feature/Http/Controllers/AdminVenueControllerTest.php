<?php

namespace Tests\Feature\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\AdminVenueController
 */
class AdminVenueControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function create_returns_an_ok_response()
    {
        $this->markTestIncomplete( __FUNCTION__ .' has issues.');

        $agreements = \App\Models\Agreement::factory()->times(3)->create();

        $response = $this->get(route('venue_create'));

        $response->assertOk();
        $response->assertViewIs('admin.venue');
        $response->assertViewHas('data');

        // TODO: perform additional assertions
    }

    /**
     * @test
     */
    public function destroy_returns_an_ok_response()
    {
        $this->markTestIncomplete( __FUNCTION__ .' has issues.');

        $venue = \App\Models\Venue::factory()->create();

        $response = $this->delete(route('venue_destroy'));

        $response->assertRedirect(route('venues_list'));
        $this->assertDeleted($venueDestroy);

        // TODO: perform additional assertions
    }

    /**
     * @test
     */
    public function destroy_validates_with_a_form_request()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\AdminVenueController::class,
            'destroy',
            \App\Http\Requests\Venues\DestroyVenueRequest::class
        );
    }

    /**
     * @test
     */
    public function edit_returns_an_ok_response()
    {
        $this->markTestIncomplete( __FUNCTION__ .' has issues.');

        $venue = \App\Models\Venue::factory()->create();
        $agreements = \App\Models\Agreement::factory()->times(3)->create();

        $response = $this->get(route('venue_edit', ['any_venue' => $any_venue]));

        $response->assertOk();
        $response->assertViewIs('admin.venue');
        $response->assertViewHas('data');

        // TODO: perform additional assertions
    }

    /**
     * @test
     */
    public function index_returns_an_ok_response()
    {
        $this->markTestIncomplete( __FUNCTION__ .' has issues.');

        $venues = \App\Models\Venue::factory()->times(3)->create();

        $response = $this->get(route('venues_list'));

        $response->assertOk();
        $response->assertViewIs('admin.listvenues');
        $response->assertViewHas('data');

        // TODO: perform additional assertions
    }

    /**
     * @test
     */
    public function store_returns_an_ok_response()
    {
        $this->markTestIncomplete( __FUNCTION__ .' has issues.');

        $response = $this->post('admin/venue/create', [
            // TODO: send request data
        ]);

        $response->assertRedirect(route('venue_edit', [$venue->slug]));

        // TODO: perform additional assertions
    }

    /**
     * @test
     */
    public function store_validates_with_a_form_request()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\AdminVenueController::class,
            'store',
            \App\Http\Requests\Venues\StoreVenueRequest::class
        );
    }

    /**
     * @test
     */
    public function update_returns_an_ok_response()
    {
        $this->markTestIncomplete( __FUNCTION__ .' has issues.');

        $venue = \App\Models\Venue::factory()->create();

        $response = $this->post('admin/venue/{any_venue}/edit', [
            // TODO: send request data
        ]);

        $response->assertRedirect(route('venue_edit', [$any_venue->slug]));

        // TODO: perform additional assertions
    }

    /**
     * @test
     */
    public function update_validates_with_a_form_request()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\AdminVenueController::class,
            'update',
            \App\Http\Requests\Venues\UpdateVenueRequest::class
        );
    }

    // test cases...
}
