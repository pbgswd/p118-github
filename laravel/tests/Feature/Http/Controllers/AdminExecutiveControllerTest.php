<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Executive;
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
        $this->markTestSkipped(__FUNCTION__);
        $response = $this->actingAs($this->admin_user)
            ->get(route('admin_executive_create', $this->executive_user->id));
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
        $this->markTestSkipped(__FUNCTION__);
        $response = $this->actingAs($this->admin_user)
            ->delete(route('admin_executive_destroy'), ['id' => $this->executive_user->id]);
//todo delete the entry for the executive title in executive_user table
        $this->assertModelMissing($this->executive_user);
        $response->assertRedirect(route('admin_executives_list'));
    }

    /**
     * @test
     */
    public function destroy_validates_with_a_form_request()
    {
        $this->markTestSkipped(__FUNCTION__);
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
        //todo  by way of how its done in the code; better
        $this->markTestSkipped(__FUNCTION__);


        $response = $this->actingAs($this->admin_user)
            ->get(route('admin_executive_edit', $this->executive_user->id));

        $response->assertOk();
        $response->assertViewIs('admin.executive');
    }

    /**
     * @test
     * @group indexok
     */
    public function index_returns_an_ok_response()
    {
        $this->markTestSkipped(__FUNCTION__);
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
        $this->markTestSkipped(__FUNCTION__);
        //$executive = \App\Models\Executive::factory()->make();
//todo the data for submitting etc
        $response = $this->actingAs($this->admin_user)
            ->post(route('admin_executive_store', $this->executive_user),
                ['executive' => $executive->toArray()]
            );

        $this->assertEquals(Session::get('success'), 'You have created a member executive role');
    }

    /**
     * @test
     * @group storeok
     */
    public function store_validates_with_a_form_request()
    {
        $this->markTestSkipped(__FUNCTION__);
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
        $this->markTestSkipped(__FUNCTION__);
       // $executiveMembership = \App\Models\Executive::factory()->create();
        $data = Executive::first();

        //todo update the properties of the executive title for the user

        $response = $this->actingAs($this->admin_user)
            ->post(route('admin_executive_update', $data->id),[
            'executive' => $data->toArray()
        ]);
        $response->assertRedirect(route('admin_executive_edit', $data->id));
    }

    /**
     * @test
     */
    public function update_validates_with_a_form_request()
    {
        $this->markTestSkipped(__FUNCTION__);
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\AdminExecutiveController::class,
            'update',
            \App\Http\Requests\Executive\UpdateAdminExecutive::class
        );
    }
}
