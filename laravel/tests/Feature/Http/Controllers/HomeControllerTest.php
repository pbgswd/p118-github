<?php

namespace Tests\Feature\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\HomeController
 */
class HomeControllerTest extends TestCase
{
    //

    /**
     * @test
     *
     * @group indexok
     */
    public function index_returns_an_ok_response(): void
    {
        $response = $this->actingAs($this->user)->get(route('landing_page'));
        $response->assertOk();
        $response->assertViewIs('site');
    }

    /**
     * @test
     *
     * @group indexnot
     */
    public function index_unauthenticated_returns_an_ok_response(): void
    {
        Auth::logout();
        $response = $this->get(route('home'));
        $response->assertRedirect('/login');
    }
}
