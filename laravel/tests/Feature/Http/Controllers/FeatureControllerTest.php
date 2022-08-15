<?php

namespace Tests\Feature\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\FeatureController
 */
class FeatureControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function index_returns_an_ok_response()
    {
        $this->markTestIncomplete( __FUNCTION__ .' has issues.');

        $features = \App\Models\Feature::factory()->times(3)->create();
        $user = \App\Models\User::factory()->create();

        $response = $this->actingAs($user)->get(route('features'));

        $response->assertOk();
        $response->assertViewIs('features');
        $response->assertViewHas('data');


    }

    /**
     * @test
     */
    public function show_returns_an_ok_response()
    {
        $this->markTestIncomplete( __FUNCTION__ .' has issues.');

        $feature = \App\Models\Feature::factory()->create();
        $user = \App\Models\User::factory()->create();

        $response = $this->actingAs($user)->get(route('feature', [$feature]));

        $response->assertOk();
        $response->assertViewIs('feature');
        $response->assertViewHas('data');


    }


}
