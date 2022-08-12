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
    use RefreshDatabase;

    /**
     * @test
     */
    public function list_returns_an_ok_response()
    {
        $this->markTestIncomplete( __FUNCTION__ .' has issues.');

        $organizations = \App\Models\Organization::factory()->times(3)->create();

        $response = $this->get(route('organizations'));

        $response->assertOk();
        $response->assertViewIs('organizations');
        $response->assertViewHas('data');

        // TODO: perform additional assertions
    }

    /**
     * @test
     */
    public function show_returns_an_ok_response()
    {
        $this->markTestIncomplete( __FUNCTION__ .' has issues.');

        $organization = \App\Models\Organization::factory()->create();

        $response = $this->get(route('organization', [$organization]));

        $response->assertOk();
        $response->assertViewIs('organization');
        $response->assertViewHas('data');

        // TODO: perform additional assertions
    }

    // test cases...
}
