<?php

namespace Tests\Feature\Http\Controllers;

use Tests\TestCase;

/**
 * @see \App\Http\Controllers\FeatureController
 */
class FeatureControllerTest extends TestCase
{
    //

    /**
     * @test
     */
    public function index_returns_an_ok_response(): void
    {
        $features = \App\Models\Feature::factory()->times(3)->create();

        $response = $this->actingAs($this->user)->get(route('features'));

        $response->assertOk();
        $response->assertViewIs('features');
        $response->assertViewHas('data');
    }

    /**
     * @test
     */
    public function show_returns_an_ok_response(): void
    {
        $feature = \App\Models\Feature::factory()->create();

        $response = $this->actingAs($this->user)->get(route('feature', [$feature]));

        $response->assertOk();
        $response->assertViewIs('feature');
        $response->assertViewHas('data');
    }
}
