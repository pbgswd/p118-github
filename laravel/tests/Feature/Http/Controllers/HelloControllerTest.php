<?php

namespace Tests\Feature\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\HelloController
 */
class HelloControllerTest extends TestCase
{
    /**
     * @test
     */
    public function index_returns_an_ok_response()
    {
        $this->markTestIncomplete( __FUNCTION__ .' has issues.');

        $response = $this->get(route('hello'));

        $response->assertOk();
        $response->assertViewIs('hello');

        // TODO: perform additional assertions
    }

    // test cases...
}
