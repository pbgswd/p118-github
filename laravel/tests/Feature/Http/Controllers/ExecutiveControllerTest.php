<?php

namespace Tests\Feature\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\ExecutiveController
 */
class ExecutiveControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function index_returns_an_ok_response()
    {
        $this->markTestIncomplete( __FUNCTION__ .' has issues.');

        $executives = \App\Models\Executive::factory()->times(3)->create();
        $committees = \App\Models\Committee::factory()->times(3)->create();

        $response = $this->get(route('executive'));

        $response->assertOk();
        $response->assertViewIs('executive_list');
        $response->assertViewHas('data');


    }


}
