<?php

namespace Tests\Feature\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\PageController
 */
class PageControllerTest extends TestCase
{
    //use RefreshDatabase;

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
        $this->markTestIncomplete( __FUNCTION__ .' has issues.');

        $page = \App\Models\Page::factory()->create();

        $response = $this->get(route('page_show', [$page]));

      //  $response->assertRedirect('login');
        $response->assertRedirect(route('page_show', [$page->slug]));

    }
}
