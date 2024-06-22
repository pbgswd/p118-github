<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Bylaw;
use Illuminate\Support\Facades\Session;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\AdminByLawController
 */
class AdminByLawControllerTest extends TestCase
{
    /**
     * @test
     */
    public function create_returns_an_ok_response(): void
    {
        $response = $this->actingAs($this->admin_user)->get(route('admin_bylaw_create'));

        $response->assertOk();
        $response->assertViewIs('admin.bylaw');
        $response->assertViewHas('data');
    }

    /**
     * @test
     *
     * @group
     */
    public function destroy_returns_an_ok_response(): void
    {
        $bylaw = \App\Models\Bylaw::factory()->create();

        $response = $this->actingAs($this->admin_user)
            ->delete(route('admin_bylaw_destroy', ['id' => $bylaw->id]));

        $this->assertModelMissing($bylaw);
        $response->assertRedirect(route('admin_bylaws_list'));
    }

    /**
     * @test
     *
     * @group
     */
    public function destroy_validates_with_a_form_request(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\AdminByLawController::class,
            'destroy',
            \App\Http\Requests\Bylaws\DestroyBylawRequest::class
        );
    }

    /**
     * @test
     */
    public function edit_returns_an_ok_response(): void
    {
        $bylaw = \App\Models\Bylaw::factory()->create();

        $response = $this->actingAs($this->admin_user)
            ->get(route('admin_bylaw_edit', $bylaw->id));

        $response->assertOk();
        $response->assertViewIs('admin.bylaw');
        $response->assertViewHas('data');
    }

    /**
     * @test
     *
     * @group indexok
     */
    public function index_returns_an_ok_response(): void
    {
        $bylaws = \App\Models\Bylaw::factory()->times(3)->create();

        $response = $this->actingAs($this->admin_user)->get(route('admin_bylaws_list'));

        $response->assertOk();
        $response->assertViewIs('admin.bylaws_list');
        $response->assertViewHas('data');
    }

    /**
     * @test
     *
     * @group storeok
     */
    public function store_returns_an_ok_response(): void
    {
        $bylaw = \App\Models\Bylaw::factory()->make();

        $response = $this->actingAs($this->admin_user)->post('admin/bylaw/create', [
            'bylaw' => $bylaw->toArray(),
        ]);

        $this->assertEquals(Session::get('success'), 'bylaw posting saved');
    }

    /**
     * @test
     *
     * @group storeok
     */
    public function store_validates_with_a_form_request(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\AdminByLawController::class,
            'store',
            \App\Http\Requests\Bylaws\StoreBylawRequest::class
        );
    }

    /**
     * @test
     *
     * @group updateok
     */
    public function update_returns_an_ok_response(): void
    {
        $bylaw = \App\Models\Bylaw::factory()->create();

        $data = Bylaw::first();

        $data['description'] = 'Description edit '.$data->description;

        $response = $this->actingAs($this->admin_user)
            ->post('admin/bylaw/'.$data->id.'/edit', [
                'bylaw' => $data->toArray(),
            ]);

        $response->assertRedirect(route('admin_bylaw_edit', ['any_bylaw' => $data->id]));
    }

    /**
     * @test
     *
     * @group updateok
     */
    public function update_validates_with_a_form_request(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\AdminByLawController::class,
            'update',
            \App\Http\Requests\Bylaws\UpdateBylawRequest::class
        );
    }
}
