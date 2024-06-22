<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Bylaw;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\ByLawController
 */
class ByLawControllerTest extends TestCase
{
    /**
     * @test
     *
     * @group listok
     */
    public function list_returns_an_ok_response(): void
    {
        $bylaws = Bylaw::factory()->times(3)->create();

        $response = $this->get(route('bylaws_list_public'));

        $response->assertOk();
        $response->assertViewIs('bylaws_list');
        $response->assertViewHas('data');
    }

    /**
     * @test
     *
     * @group showok
     */
    public function show_returns_an_ok_response(): void
    {
        $bylaw = Bylaw::factory()->create();

        $response = $this->get(route('bylaw_show', $bylaw->id));

        $response->assertOk();
        $response->assertViewIs('bylaw_view');
        $response->assertViewHas('data');
    }
}
