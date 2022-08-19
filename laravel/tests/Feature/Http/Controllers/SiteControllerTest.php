<?php

namespace Tests\Feature\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\SiteController
 */
class SiteControllerTest extends TestCase
{
   // use RefreshDatabase;

    /**
     * @test
     */
    public function index_returns_an_ok_response()
    {
        $user = \App\Models\User::factory()->create();

        $response = $this->actingAs($user)->get(route('landing_page'));

        $response->assertOk();
        $response->assertViewIs('site');
        $response->assertViewHas('data');
    }
}
