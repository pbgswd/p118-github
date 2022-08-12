<?php

namespace Tests\Feature\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\CarouselController
 */
class CarouselControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function show_returns_an_ok_response()
    {
        $this->markTestIncomplete( __FUNCTION__ .' has issues.');

        $carousel = \App\Models\Carousel::factory()->create();

        $response = $this->get(route('carousel'));

        $response->assertOk();
        $response->assertViewIs('carousel');

        // TODO: perform additional assertions
    }

    // test cases...
}
