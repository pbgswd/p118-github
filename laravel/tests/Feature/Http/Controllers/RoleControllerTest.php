<?php

namespace Tests\Feature\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\RoleController
 */
class RoleControllerTest extends TestCase
{
    /**
     * @test
     */
    public function index_returns_an_ok_response()
    {
        $this->markTestIncomplete( __FUNCTION__ .' has issues.');

        $response = $this->get(route('roles_list'));

        $response->assertOk();
        $response->assertViewIs('admin.roles');
        $response->assertViewHas('data');

        // TODO: perform additional assertions
    }

    // test cases...
}
