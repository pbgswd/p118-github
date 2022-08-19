<?php

namespace Tests\Feature\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\OrganizationController
 */
class OrganizationControllerTest extends TestCase
{
  //  use RefreshDatabase;

    /**
     * @test
     */
    public function list_returns_an_ok_response()
    {
        $organizations = \App\Models\Organization::factory()->times(3)->create();

        $response = $this->get(route('organizations'));

        $response->assertOk();
        $response->assertViewIs('organizations');
        $response->assertViewHas('data');
    }

    /**
     * @test
     */
    public function show_returns_an_ok_response()
    {
        $organization = \App\Models\Organization::factory()->create();

        $response = $this->get(route('organization', [$organization]));

        $response->assertOk();
        $response->assertViewIs('organization');
        $response->assertViewHas('data');
    }
}
