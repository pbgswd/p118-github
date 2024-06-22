<?php

namespace Tests\Feature\Http\Controllers;

use Tests\TestCase;

/**
 * @see \App\Http\Controllers\PageController
 */
class PageControllerTest extends TestCase
{
    //

    /**
     * @test
     */
    public function list_returns_an_ok_response()
    {
        //  $this->markTestIncomplete( __FUNCTION__ .' has issues.');

        $pages = \App\Models\Page::factory()->times(3)->create();

        $response = $this->get(route('pages'));

        $response->assertOk();
        $response->assertViewIs('pages');
        $response->assertViewHas('data');
    }

    /**
     * @test
     */
    public function show_returns_an_ok_response()
    {
        $page = \App\Models\Page::factory()->create();
        $response = $this->get(route('page_show', [$page]));
        $response->assertOk();
        $response->assertViewIs('page');
        $response->assertViewHas('data');
    }
}
