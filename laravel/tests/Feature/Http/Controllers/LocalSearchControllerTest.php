<?php

namespace Tests\Feature\Http\Controllers;

use Tests\TestCase;

/**
 * @see \App\Http\Controllers\LocalSearchController
 */
class LocalSearchControllerTest extends TestCase
{


    /**
     * @test
     * @adminsearchreturnsok
     */
    public function admin_attachment_search_returns_an_ok_response()
    {
      $this->markTestIncomplete( __FUNCTION__ .' has issues. Needs data in attachments table ');

//todo there need to be attachments to return in the search

        $response = $this->actingAs( $this->admin_user)
            ->post(route('list_attachments_search_result'), [
                'search' => " "
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
        $post = \App\Models\Post::factory()->create();

        $response = $this->post(route('admin_search'), [
            "search" => $post->title
        ]);

        $response->assertRedirect(route('admin_search'));
       // $response->assertOk();
       // $response->assertViewIs('admin.search_admin');
        //$response->assertViewHas('data');
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
    public function index_validates_with_a_form_request()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\LocalSearchController::class,
            'index',
            \App\Http\Requests\Search\LocalSearchResult::class
        );
    }
}
