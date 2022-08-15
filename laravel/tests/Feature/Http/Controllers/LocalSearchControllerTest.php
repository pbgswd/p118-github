<?php

namespace Tests\Feature\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\LocalSearchController
 */
class LocalSearchControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function admin_attachment_search_returns_an_ok_response()
    {
        $this->markTestIncomplete( __FUNCTION__ .' has issues.');

        $response = $this->post(route('list_attachments_search_result'), [
            // TODO: send request data
        ]);

        $response->assertOk();
        $response->assertViewIs('admin.list_attachments_search_result');
        $response->assertViewHas('data');


    }

    /**
     * @test
     */
    public function admin_attachment_search_validates_with_a_form_request()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\LocalSearchController::class,
            'admin_attachment_search',
            \App\Http\Requests\Search\LocalSearchResult::class
        );
    }

    /**
     * @test
     */
    public function admin_search_returns_an_ok_response()
    {
        $this->markTestIncomplete( __FUNCTION__ .' has issues.');

        $response = $this->post(route('admin_search'), [
            // TODO: send request data
        ]);

        $response->assertOk();
        $response->assertViewIs('admin.search_admin');
        $response->assertViewHas('data');


    }

    /**
     * @test
     */
    public function admin_search_validates_with_a_form_request()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\LocalSearchController::class,
            'admin_search',
            \App\Http\Requests\Search\LocalSearchResult::class
        );
    }

    /**
     * @test
     */
    public function index_returns_an_ok_response()
    {
        $this->markTestIncomplete( __FUNCTION__ .' has issues.');

        $user = \App\Models\User::factory()->create();

        $response = $this->actingAs($user)->post(route('search'), [
            // TODO: send request data
        ]);

        $response->assertOk();
        $response->assertViewIs('search');
        $response->assertViewHas('data');


    }

    /**
     * @test
     */
    public function index_validates_with_a_form_request()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\LocalSearchController::class,
            'index',
            \App\Http\Requests\Search\LocalSearchResult::class
        );
    }


}
