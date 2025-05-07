<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Venue;
use Illuminate\Support\Facades\Session;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\Admin\AdminVenueController
 */
class AdminVenueControllerTest extends TestCase
{
    //

    /**
     * @test
     *
     * @group createok
     */
    public function create_returns_an_ok_response(): void
    {
        $response = $this->actingAs($this->admin_user)
            ->get(route('venue_create'));

        $response->assertOk();
        $response->assertViewIs('admin.venue');
        $response->assertViewHas('data');
    }

    /**
     * @test
     *
     * @group destroyok
     */
    public function destroy_returns_an_ok_response(): void
    {
        $venue = \App\Models\Venue::factory()->create();

        $response = $this->actingAs($this->admin_user)
            ->delete(route('venue_destroy', ['id' => $venue->id]));
        $this->assertModelMissing($venue);
        $response->assertRedirect(route('venues_list'));
    }

    /**
     * @test
     *
     * @group destroyok
     */
    public function destroy_validates_with_a_form_request(): void
    {
        $this->actingAs($this->admin_user)->assertActionUsesFormRequest(
            \App\Http\Controllers\Admin\AdminVenueController::class,
            'destroy',
            \App\Http\Requests\Venues\DestroyVenueRequest::class
        );
    }

    /**
     * @test
     *
     * @group editok
     */
    public function edit_returns_an_ok_response(): void
    {
        $venue = \App\Models\Venue::factory()->create();

        $response = $this->actingAs($this->admin_user)
            ->get(route('venue_edit', $venue->slug));

        $response->assertOk();
        $response->assertViewIs('admin.venue');
        $response->assertViewHas('data');
    }

    /**
     * @test
     *
     * @group indexok
     */
    public function index_returns_an_ok_response(): void
    {
        $venues = \App\Models\Venue::factory()->times(3)->create();

        $response = $this->actingAs($this->admin_user)
            ->get(route('venues_list'));

        $response->assertOk();
        $response->assertViewIs('admin.listvenues');
        $response->assertViewHas('data');
    }

    /**
     * @test
     *
     * @group storeok
     */
    public function store_returns_an_ok_response(): void
    {
        $venue = \App\Models\Venue::factory()->make();

        $response = $this->actingAs($this->admin_user)
            ->post('admin/venue/create', [
                'venue' => $venue->toArray(),
            ]);
        // both work, but issues
        // $response->assertRedirect(route('venue_edit', [$venue->slug]));
        $this->assertEquals(Session::get('success'), 'You have saved a new venue');
    }

    /**
     * @test
     *
     * @group storeok
     */
    public function store_validates_with_a_form_request(): void
    {
        $this->actingAs($this->admin_user)->assertActionUsesFormRequest(
            \App\Http\Controllers\Admin\AdminVenueController::class,
            'store',
            \App\Http\Requests\Venues\StoreVenueRequest::class
        );
    }

    /**
     * @test
     *
     * @group updateok
     */
    public function update_returns_an_ok_response(): void
    {
        $venue = \App\Models\Venue::factory()->create();

        $data = Venue::first();

        $response = $this->actingAs($this->admin_user)
            ->post('admin/venue/'.$venue->slug.'/edit', [
                'venue' => $data->toArray(),
            ]);

        $response->assertRedirect(route('venue_edit', $venue->slug));
    }

    /**
     * @test
     *
     * @group updateok
     */
    public function update_validates_with_a_form_request(): void
    {
        $this->actingAs($this->admin_user)->assertActionUsesFormRequest(
            \App\Http\Controllers\Admin\AdminVenueController::class,
            'update',
            \App\Http\Requests\Venues\UpdateVenueRequest::class
        );
    }
}
