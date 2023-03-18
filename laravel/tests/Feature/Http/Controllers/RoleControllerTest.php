<?php

namespace Tests\Feature\Http\Controllers;

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
        $response = $this->actingAs($this->admin_user)
            ->get(route('roles_list'));

        $response->assertOk();
        $response->assertViewIs('admin.roles');
        $response->assertViewHas('data');
    }
}
