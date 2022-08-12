<?php

namespace Tests\Feature\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\PolicyController
 */
class PolicyControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function index_returns_an_ok_response()
    {
        $this->markTestIncomplete( __FUNCTION__ .' has issues.');

        $policies = \App\Models\Policy::factory()->times(3)->create();
        $user = \App\Models\User::factory()->create();

        $response = $this->actingAs($user)->get(route('policies_list_public'));

        $response->assertOk();
        $response->assertViewIs('policies_list');
        $response->assertViewHas('data');

        // TODO: perform additional assertions
    }

    /**
     * @test
     */
    public function show_returns_an_ok_response()
    {
        $this->markTestIncomplete( __FUNCTION__ .' has issues.');

        $policy = \App\Models\Policy::factory()->create();
        $user = \App\Models\User::factory()->create();

        $response = $this->actingAs($user)->get(route('policy_show_public', [$policy]));

        $response->assertOk();
        $response->assertViewIs('policy_view');
        $response->assertViewHas('data');

        // TODO: perform additional assertions
    }

    // test cases...
}
