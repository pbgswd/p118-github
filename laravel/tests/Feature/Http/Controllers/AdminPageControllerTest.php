<?php

namespace Tests\Feature\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\AdminPageController
 */
class AdminPageControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function create_returns_an_ok_response()
    {
        $this->markTestIncomplete( __FUNCTION__ .' has issues.');

        $topics = \App\Models\Topic::factory()->times(3)->create();

        $response = $this->get(route('page_create'));

        $response->assertOk();
        $response->assertViewIs('admin.page');
        $response->assertViewHas('data');

        // TODO: perform additional assertions
    }

    /**
     * @test
     */
    public function destroy_returns_an_ok_response()
    {
        $this->markTestIncomplete( __FUNCTION__ .' has issues.');

        $page = \App\Models\Page::factory()->create();

        $response = $this->delete(route('page_destroy'));

        $response->assertRedirect(route('pages_list'));
        $this->assertDeleted($pageDestroy);

        // TODO: perform additional assertions
    }

    /**
     * @test
     */
    public function destroy_validates_with_a_form_request()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\AdminPageController::class,
            'destroy',
            \App\Http\Requests\Page\DestroyPageRequest::class
        );
    }

    /**
     * @test
     */
    public function edit_returns_an_ok_response()
    {
        $this->markTestIncomplete( __FUNCTION__ .' has issues.');

        $page = \App\Models\Page::factory()->create();
        $topics = \App\Models\Topic::factory()->times(3)->create();

        $response = $this->get(route('page_edit', ['any_page' => $any_page]));

        $response->assertOk();
        $response->assertViewIs('admin.page');
        $response->assertViewHas('data');

        // TODO: perform additional assertions
    }

    /**
     * @test
     */
    public function index_returns_an_ok_response()
    {
        $this->markTestIncomplete( __FUNCTION__ .' has issues.');

        $pages = \App\Models\Page::factory()->times(3)->create();

        $response = $this->get(route('pages_list'));

        $response->assertOk();
        $response->assertViewIs('admin.listpages');
        $response->assertViewHas('data');

        // TODO: perform additional assertions
    }

    /**
     * @test
     */
    public function store_returns_an_ok_response()
    {
        $this->markTestIncomplete( __FUNCTION__ .' has issues.');

        $response = $this->post('admin/page/create', [
            // TODO: send request data
        ]);

        $response->assertRedirect(route('page_edit', [$page->slug]));

        // TODO: perform additional assertions
    }

    /**
     * @test
     */
    public function store_validates_with_a_form_request()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\AdminPageController::class,
            'store',
            \App\Http\Requests\Page\StorePageRequest::class
        );
    }

    /**
     * @test
     */
    public function update_returns_an_ok_response()
    {
        $this->markTestIncomplete( __FUNCTION__ .' has issues.');

        $page = \App\Models\Page::factory()->create();

        $response = $this->post(route('admin_update_page', ['any_page' => $any_page]), [
            // TODO: send request data
        ]);

        $response->assertRedirect(route('page_edit', [$any_page->slug]));

        // TODO: perform additional assertions
    }

    /**
     * @test
     */
    public function update_validates_with_a_form_request()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\AdminPageController::class,
            'update',
            \App\Http\Requests\Page\UpdatePageRequest::class
        );
    }

    // test cases...
}
