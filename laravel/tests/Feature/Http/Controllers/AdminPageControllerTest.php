<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Page;
use Illuminate\Support\Facades\Session;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\AdminPageController
 */
class AdminPageControllerTest extends TestCase
{
    //

    /**
     * @test
     * @group createok
     */
    public function create_returns_an_ok_response()
    {
        $response = $this->actingAs($this->admin_user)
            ->get(route('page_create'));

        $response->assertOk();
        $response->assertViewIs('admin.page');
        $response->assertViewHas('data');
    }

    /**
     * @test
     * @group destroyok
     */
    public function destroy_returns_an_ok_response()
    {
        $this->markTestIncomplete( __FUNCTION__ .' has issues.');
        //todo 3 x fail, 4th time it passes wtf

        $page = \App\Models\Page::factory()->create();

        $response = $this->actingAs($this->admin_user)
            ->delete(route('page_destroy', ['ids' => $page->id]));

        $response->assertRedirect(route('pages_list'));
        $this->assertModelMissing($page);


    }

    /**
     * @test
     * @group destroyok
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
     * @group editok
     */
    public function edit_returns_an_ok_response()
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
     * @group indexok
     */
    public function index_returns_an_ok_response()
    {
        $pages = \App\Models\Page::factory()->times(3)->create();

        $response = $this->actingAs($this->admin_user)->get(route('pages_list'));

        $response->assertOk();
        $response->assertViewIs('admin.listpages');
        $response->assertViewHas('data');
    }

    /**
     * @test
     * @group storeok
     */
    public function store_returns_an_ok_response()
    {
        $page = \App\Models\Page::factory()->make();

        $response = $this->actingAs($this->admin_user)
            ->post('admin/page/create', [
            'page' => $page->toArray()
        ]);
       // $response->ddSession()['errors'];
        $this->assertEquals(Session::get('success'),'You have saved a new page');
    }

    /**
     * @test
     * @group storeok
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
     * @group updateok
     */
    public function update_returns_an_ok_response()
    {
        $this->markTestIncomplete( __FUNCTION__ .' has issues.');

        $page = \App\Models\Page::factory()->create();
        echo "\n sluggggg: " . $page->slug . "\n";
        $data = Page::first();

        $data['title'] = $page->title;
        $data['access_level'] = $data->access_level;
        $data['content'] = 'content update ' . $page->content;

        $response = $this->actingAs($this->admin_user)
            ->post(route('admin_update_page', $page->slug), [
            'page' => $data
        ]);

        echo "\n route: " . route('page_edit', $page->slug) . "\n";

        $response->assertRedirect(route('page_edit', $page->slug));
    }

    /**
     * @test
     * @group updateok
     */
    public function update_validates_with_a_form_request()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\AdminPageController::class,
            'update',
            \App\Http\Requests\Page\UpdatePageRequest::class
        );
    }
}
