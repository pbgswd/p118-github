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
    use RefreshDatabase;

    /**
     * @test
     */
    public function index_returns_an_ok_response()
    {
        $this->markTestIncomplete( __FUNCTION__ .' has issues.');

        $committees = \App\Models\Committee::factory()->times(3)->create();
        $user = \App\Models\User::factory()->create();

        $response = $this->actingAs($user)->get(route('committees'));

        $response->assertOk();
        $response->assertViewIs('committees');
        $response->assertViewHas('data');

        // TODO: perform additional assertions
    }

    /**
     * @test
     */
    public function show_returns_an_ok_response()
    {
        $this->markTestIncomplete( __FUNCTION__ .' has issues.');

        $committee = \App\Models\Committee::factory()->create();
        $user = \App\Models\User::factory()->create();

        $response = $this->actingAs($user)->get(route('committee', [$committee]));

        $response->assertOk();
        $response->assertViewIs('committee');
        $response->assertViewHas('data');

        // TODO: perform additional assertions
    }

    // test cases...
}
