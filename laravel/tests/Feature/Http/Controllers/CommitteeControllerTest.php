<?php

namespace Tests\Feature\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
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
        $committees = \App\Models\Committee::factory()->times(3)->create();

        $response = $this->actingAs($this->admin_user)
            ->get(route('committees'));

        $response->assertOk();
        $response->assertViewIs('committees');
        $response->assertViewHas('data');
    }

    /**
     * @test
     * @group showok
     */
    public function show_returns_an_ok_response()
    {
        $this->markTestIncomplete( __FUNCTION__ .' has issues.');

        $committee = \App\Models\Committee::factory()->create();

        $response = $this->actingAs($this->admin_user)
            ->get(route('committee', $committee->slug));

        $response->assertOk();
        $response->assertViewIs('committee');
        $response->assertViewHas('data');
    }
}
