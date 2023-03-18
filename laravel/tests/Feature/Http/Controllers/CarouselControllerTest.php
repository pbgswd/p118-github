<?php

namespace Tests\Feature\Http\Controllers;

use Tests\TestCase;

/**
 * @see \App\Http\Controllers\CarouselController
 */
class CarouselControllerTest extends TestCase
{


    /**
     * @test
     */
    public function show_returns_an_ok_response()
    {
      //  $this->markTestIncomplete( __FUNCTION__ .' has no code.');
        //$carousel = \App\Models\Carousel::factory()->create();

        $response = $this->get(route('carousel'));

        $response->assertOk();
        $response->assertViewIs('carousel');
    }
}
