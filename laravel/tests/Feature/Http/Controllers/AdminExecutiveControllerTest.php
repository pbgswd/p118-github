<?php

namespace Tests\Feature\Http\Controllers;

use Tests\TestCase;

/**
 * @see \App\Http\Controllers\AdminExecutiveController
 */
class AdminExecutiveControllerTest extends TestCase
{
    //

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
