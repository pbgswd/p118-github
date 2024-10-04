<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Page;
use Illuminate\Support\Facades\Session;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\Admin\AdminPageController
 */
class AdminPageControllerTest extends TestCase
{
    //

    /**
     * @test
     *
     * @group createok
     */
    public function create_returns_an_ok_response(): void
    {
        $response = $this->actingAs($this->admin_user)
            ->get(route('page_create'));

        $response->assertOk();
        $response->assertViewIs('admin.page');
        $response->assertViewHas('data');
    }

    /**
     * @test
     *
     * @group destroyok
     */
    public function destroy_returns_an_ok_response(): void
    {
        $page = \App\Models\Page::factory()->create();

        $response = $this->actingAs($this->admin_user)
            ->delete(route('page_destroy', ['id' => $page->id]));
        $this->assertModelMissing($page);
        $response->assertRedirect(route('pages_list'));
    }

    /**
     * @test
     */
    public function destroy_validates_with_a_form_request(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\Admin\AdminPageController::class,
            'destroy',
            \App\Http\Requests\Page\DestroyPageRequest::class
        );
    }

    /**
     * @test
     *
     * @group editok
     */
    public function edit_returns_an_ok_response(): void
    {
        $page = \App\Models\Page::factory()->create();

        $response = $this->actingAs($this->admin_user)
            ->get(route('page_edit', ['any_page' => $page]));

        $response->assertOk();
        $response->assertViewIs('admin.page');
        $response->assertViewHas('data');
    }

    /**
     * @test
     *
     * @group indexok
     */
    public function index_returns_an_ok_response(): void
    {
        $pages = \App\Models\Page::factory()->times(3)->create();

        $response = $this->actingAs($this->admin_user)->get(route('pages_list'));

        $response->assertOk();
        $response->assertViewIs('admin.listpages');
        $response->assertViewHas('data');
    }

    /**
     * @test
     *
     * @group storeok
     */
    public function store_returns_an_ok_response(): void
    {
        $page = \App\Models\Page::factory()->make();

        $response = $this->actingAs($this->admin_user)
            ->post('admin/page/create', [
                'page' => $page->toArray(),
            ]);

        $this->assertEquals(Session::get('success'), 'You have saved a new page');
    }

    /**
     * @test
     *
     * @group storeok
     */
    public function store_validates_with_a_form_request(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\Admin\AdminPageController::class,
            'store',
            \App\Http\Requests\Page\StorePageRequest::class
        );
    }

    /**
     * @test
     *
     * @group updateok
     */
    public function update_returns_an_ok_response(): void
    {
        $page = \App\Models\Page::factory()->create();
        $data = Page::first();
        $data->content = 'content update '.$data->content;

        $response = $this->actingAs($this->admin_user)
            ->post(route('admin_update_page', $page->slug), [
                'page' => $data->toArray(),
            ]);
        $response->assertRedirect(route('page_edit', $page->slug));
    }

    /**
     * @test
     */
    public function update_validates_with_a_form_request(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\Admin\AdminPageController::class,
            'update',
            \App\Http\Requests\Page\UpdatePageRequest::class
        );
    }
}
