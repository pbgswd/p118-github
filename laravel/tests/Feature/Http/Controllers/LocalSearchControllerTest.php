<?php

namespace Tests\Feature\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\LocalSearchController
 */
class LocalSearchControllerTest extends TestCase
{

    /**
     * @test
     * @group adminsearchreturnsok
     */
    public function admin_attachment_search_returns_an_ok_response()
    {
        $attachment = \App\Models\Attachment::factory()->create();

        $response = $this->actingAs( $this->admin_user)
            ->post(route('list_attachments_search_result'), [
                'search' => $attachment->description
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
     * @group amsearchok
     *
     */
    public function admin_search_returns_an_ok_response()
    {
        $post = \App\Models\Post::factory()->create(['user_id' => $this->admin_user]);

        $response = $this->actingAs($this->admin_user)->post(route('admin_search'), [
            "search" => $post->title
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
    public function index_validates_with_a_form_request()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\LocalSearchController::class,
            'index',
            \App\Http\Requests\Search\LocalSearchResult::class
        );
    }
}
