<?php

namespace Tests\Feature\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\VenueController
 */
class VenueControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function list_returns_an_ok_response()
    {
        $this->markTestIncomplete( __FUNCTION__ .' has issues.');

        $venues = \App\Models\Venue::factory()->times(3)->create();

        $response = $this->get(route('venues'));

        $response->assertOk();
        $response->assertViewIs('venues');
        $response->assertViewHas('data');


    }

    /**
     * @test
     */
    public function show_returns_an_ok_response()
    {
        $this->markTestIncomplete( __FUNCTION__ .' has issues.');

        $venue = \App\Models\Venue::factory()->create();

        $response = $this->get(route('venue', [$venue]));

        $response->assertOk();
        $response->assertViewIs('venue');
        $response->assertViewHas('data');


    }


}
