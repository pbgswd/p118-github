<?php

namespace Tests\Feature\Http\Controllers;

use Tests\TestCase;

/**
 * @see \App\Http\Controllers\MemoriamController
 */
class MemoriamControllerTest extends TestCase
{
    //

    /**
     * @test
     */
    public function index_returns_an_ok_response()
    {
      //  $this->markTestIncomplete( __FUNCTION__ .' has issues.');

        $memoriams = \App\Models\Memoriam::factory()->times(3)->create();

        $response = $this->get(route('memoriam_list'));

        $response->assertOk();
        $response->assertViewIs('memoriams');
        $response->assertViewHas('data');


    }

    /**
     * @test
     */
    public function show_returns_an_ok_response()
    {
      //  $this->markTestIncomplete( __FUNCTION__ .' has issues.');

        $memoriam = \App\Models\Memoriam::factory()->create();

        $response = $this->get(route('memoriam', [$memoriam]));

        $response->assertOk();
        $response->assertViewIs('memoriam');
        $response->assertViewHas('data');


    }


}
