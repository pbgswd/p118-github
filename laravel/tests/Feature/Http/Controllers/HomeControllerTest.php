<?php

namespace Tests\Feature\Http\Controllers;

use Tests\TestCase;

/**
 * @see \App\Http\Controllers\HomeController
 */
class HomeControllerTest extends TestCase
{
   //

    /**
     * @test
     */
    public function index_returns_an_ok_response()
    {
        $response = $this->actingAs($this->user)->get(route('home'));
        $response->assertRedirect('/');
    }

    /**
     * @test
     */
    public function index_unauthenticated_returns_an_ok_response()
    {
        $response = $this->get(route('home'));
        $response->assertRedirect('/login');
    }
}
