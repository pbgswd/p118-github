<?php

namespace Tests\Feature\Http\Controllers;

use Illuminate\Support\Facades\Session;
use Tests\TestCase;

//todo test to manage user exec roles
/**
 * @see \App\Http\Controllers\AdminExecutiveController
 */
class AdminExecutiveControllerTest extends TestCase
{
    /**
     * @test
     * @group createok
     */
    public function create_returns_an_ok_response()
    {
        $response = $this->actingAs($this->admin_user)
            ->get(route('admin_executive_create', $this->user->id));
        $response->assertOk();
        $response->assertViewIs('admin.executive');
        $response->assertViewHas('data');
    }

    /**
     * @test
     * @group destroyok
     */
    public function destroy_returns_an_ok_response()
    {
        $response = $this->actingAs($this->admin_user)
            ->delete(route('admin_executive_destroy'), ['id' => $this->executive_user->executive_role]);

        $this->assertModelMissing($this->executive_user->executive_role);
        $response->assertRedirect(route('admin_executives_list'));
    }

    /**
     * @test
     * @group destroyok
     */
    public function destroy_validates_with_a_form_request()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\AdminExecutiveController::class,
            'destroy',
            \App\Http\Requests\Executive\DestroyAdminExecutive::class
        );
    }

    /**
     * @test
     * @group editok
     */
    public function edit_returns_an_ok_response()
    {
        $response = $this->actingAs($this->admin_user)
            ->get(route('admin_executive_edit', $this->executive_user->executive_role));

        $response->assertOk();
        $response->assertViewIs('admin.executive');
    }

    /**
     * @test
     * @group indexok
     */
    public function index_returns_an_ok_response()
    {
        $response = $this->actingAs($this->admin_user)
            ->get(route('admin_executives_list'));

        $response->assertOk();
        $response->assertViewIs('admin.executives_list');
        $response->assertViewHas('data');
    }

    /**
     * @test
     * @group storeok
     */
    public function store_returns_an_ok_response()
    {
       // $this->markTestSkipped(__FUNCTION__);

        $data = [
            'executive_id' => 1,
            'start_date' => date('Y-m-d'),
            'end_date' => date('d-m-Y', strtotime('+1 year')),
            'user_id' => $this->user->id,
            'current' => 1,
        ];

        $response = $this->actingAs($this->admin_user)
            ->post(route('admin_executive_store', $this->user),
                ['executive' => $data]
            );

        $this->assertEquals(Session::get('success'), 'You have created a member executive role');
    }

    /**
     * @test
     * @group storeok
     */
    public function store_validates_with_a_form_request()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\AdminExecutiveController::class,
            'store',
            \App\Http\Requests\Executive\StoreAdminExecutive::class
        );
    }

    /**
     * @test
     * @group updateok
     */
    public function update_returns_an_ok_response()
    {

        $response = $this->actingAs($this->admin_user)
            ->post(route('admin_executive_update', $this->executive_user->executive_role->id),[
            'executive' => $this->executive_user->executive_role->toArray()
        ]);

        $response->assertRedirect(route('admin_executive_edit', $this->executive_user->executive_role->id));
    }

    /**
     * @test
     */
    public function update_validates_with_a_form_request()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\AdminExecutiveController::class,
            'update',
            \App\Http\Requests\Executive\UpdateAdminExecutive::class
        );
    }
}
