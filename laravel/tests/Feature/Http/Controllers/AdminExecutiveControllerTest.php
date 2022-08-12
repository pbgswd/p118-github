<?php

namespace Tests\Feature\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\AdminExecutiveController
 */
class AdminExecutiveControllerTest extends TestCase
{
    //use RefreshDatabase;

    /**
     * @test
     */
    public function index_returns_an_ok_response()
    {
        $executives = \App\Models\Executive::factory()->times(3)->create();

        $response = $this->actingAs($this->admin_user)->get(route('admin_executives'));

        $response->assertOk();
        $response->assertViewIs('admin.executives_list');
        $response->assertViewHas('data');
    }
}
