<?php

namespace Tests\Feature\Http\Controllers;

use Tests\TestCase;

/**
 * @see \App\Http\Controllers\CommitteeController
 */
class CommitteeControllerTest extends TestCase
{
    /**
     * @test
     */
    public function index_returns_an_ok_response()
    {
        $response = $this->actingAs($this->admin_user)
            ->get(route('committees'));

        $response->assertOk();
        $response->assertViewIs('committees');
        $response->assertViewHas('data');
    }

    /**
     * @test
     *
     * @group showok
     */
    public function show_returns_an_ok_response()
    {
        $response = $this->actingAs($this->admin_user)
            ->get(route('committee', $this->committee->slug));

        $response->assertOk();
        $response->assertViewIs('committee');
        $response->assertViewHas('data');
    }
}
