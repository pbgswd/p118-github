<?php

namespace Tests\Feature\Http\Controllers;

use Tests\TestCase;

/**
 * @see \App\Http\Controllers\ExecutiveController
 */
class ExecutiveControllerTest extends TestCase
{
    //

    /**
     * @test
     */
    public function index_returns_an_ok_response()
    {
        $executives = \App\Models\Executive::factory()->times(3)->create();
        $response = $this->get(route('executive'));

        $response->assertOk();
        $response->assertViewIs('executive_list');
        $response->assertViewHas('data');
    }
}
