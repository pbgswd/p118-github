<?php

namespace Tests\Feature\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\HomeController
 */
class HomeControllerTest extends TestCase
{
   // use RefreshDatabase;

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
