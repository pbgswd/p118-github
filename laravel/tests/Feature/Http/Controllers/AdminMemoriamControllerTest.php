<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Memoriam;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\Admin\AdminMemoriamController
 */
class AdminMemoriamControllerTest extends TestCase
{
    //

    /**
     * @test
     *
     * @group createok
     */
    public function create_returns_an_ok_response(): void
    {
        $response = $this->actingAs($this->admin_user)->get(route('admin_memoriam_create'));

        $response->assertOk();
        $response->assertViewIs('admin.memoriam');
        $response->assertViewHas('data');
    }

    /**
     * @test
     *
     * @group destroyok
     */
    public function destroy_returns_an_ok_response(): void
    {
        $memoriam = \App\Models\Memoriam::factory()->create();

        $response = $this->actingAs($this->admin_user)
            ->delete(route('admin_memoriam_destroy', ['id' => $memoriam->id]));

        $response->assertRedirect(route('admin_memoriam_list'));
        $this->assertModelMissing($memoriam);
    }

    /**
     * @test
     *
     * @group destroyok
     */
    public function destroy_validates_with_a_form_request(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\Admin\AdminMemoriamController::class,
            'destroy',
            \App\Http\Requests\Memoriam\DestroyMemoriamRequest::class
        );
    }

    /**
     * @test
     *
     * @group editok
     */
    public function edit_returns_an_ok_response(): void
    {
        $memoriam = \App\Models\Memoriam::factory()->create();

        $response = $this->actingAs($this->admin_user)
            ->get(route('admin_memoriam_edit', $memoriam->slug));

        $response->assertOk();
        $response->assertViewIs('admin.memoriam');
        $response->assertViewHas('data');

    }

    /**
     * @test
     *
     * @group indexok
     */
    public function index_returns_an_ok_response(): void
    {
        $memoriams = \App\Models\Memoriam::factory()->times(3)->create();

        $response = $this->actingAs($this->admin_user)->get(route('admin_memoriam_list'));

        $response->assertOk();
        $response->assertViewIs('admin.memoriams');
        $response->assertViewHas('data');
    }

    /**
     * @test
     *
     * @group storeok
     */
    public function store_returns_an_ok_response(): void
    {
        $memoriam = Memoriam::factory()->make();

        $response = $this->actingAs($this->admin_user)
            ->post('admin/memoriam/create', [
                'memoriam' => $memoriam->toArray(),
            ]);

        $response->assertRedirect(route('admin_memoriam_edit', $memoriam->slug));

    }

    /**
     * @test
     *
     * @group storeok
     */
    public function store_validates_with_a_form_request(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\Admin\AdminMemoriamController::class,
            'store',
            \App\Http\Requests\Memoriam\StoreMemoriamRequest::class
        );
    }

    /**
     * @test
     *
     * @group updateok
     */
    public function update_returns_an_ok_response(): void
    {
        // $this->markTestIncomplete( __FUNCTION__ .' has issues.');

        $memoriam = \App\Models\Memoriam::factory()->create();

        $data = Memoriam::first();

        $data['content'] = 'Update to this '.$memoriam->content;

        $response = $this->actingAs($this->admin_user)
            ->post('admin/memoriam/'.$data->slug.'/edit', [
                'memoriam' => $data->toArray(),
            ]);

        $response->assertRedirect(route('admin_memoriam_edit', $data->slug));

    }

    /**
     * @test
     *
     * @group updateok
     */
    public function update_validates_with_a_form_request(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\Admin\AdminMemoriamController::class,
            'update',
            \App\Http\Requests\Memoriam\UpdateMemoriamRequest::class
        );
    }
}
