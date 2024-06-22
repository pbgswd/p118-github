<?php

namespace Tests\Feature\Http\Controllers;

use Tests\TestCase;

/**
 * @see \App\Http\Controllers\OrganizationController
 */
class OrganizationControllerTest extends TestCase
{
    //

    /**
     * @test
     */
    public function list_returns_an_ok_response(): void
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
    public function show_returns_an_ok_response(): void
    {
        $organization = \App\Models\Organization::factory()->create();

        $response = $this->get(route('organization', [$organization]));

        $response->assertOk();
        $response->assertViewIs('organization');
        $response->assertViewHas('data');
    }
}
