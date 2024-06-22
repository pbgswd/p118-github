<?php

namespace Tests\Feature\Http\Controllers;

use Tests\TestCase;

/**
 * @see \App\Http\Controllers\SiteController
 */
class SiteControllerTest extends TestCase
{
    /**
     * @test
     */
    public function index_returns_an_ok_response(): void
    {
        $user = \App\Models\User::factory()->create();

        $response = $this->actingAs($user)->get(route('landing_page'));

        $response->assertOk();
        $response->assertViewIs('site');
        $response->assertViewHas('data');
    }
}
