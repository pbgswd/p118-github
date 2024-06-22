<?php

namespace Tests\Feature\Http\Controllers;

use Tests\TestCase;

/**
 * @see \App\Http\Controllers\HelloController
 */
class HelloControllerTest extends TestCase
{
    /**
     * @test
     */
    public function index_returns_an_ok_response(): void
    {
        $response = $this->get(route('hello'));

        $response->assertOk();
        $response->assertViewIs('hello');
    }
}
