<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Address;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\AdminUserController
 */
class AdminUserControllerTest extends TestCase
{
    //use RefreshDatabase;

    /**
     * @test
     * @group edit_address_ok
     */
    public function admin_edit_address_returns_an_ok_response()
    {
        $response = $this->actingAs($this->admin_user)
            ->get(route('admin_edit_address', $this->user->id));

        $response->assertOk();
        $response->assertViewIs('admin.user-edit-address');
        $response->assertViewHas('data');
    }

    /**
     * @test
     * @group edit_emerg_ok
     */
    public function admin_edit_emergency_contact_returns_an_ok_response()
    {
        $response = $this->actingAs($this->admin_user)
            ->get(route('admin_edit_emergency_contact', $this->user));

        $response->assertOk();
        $response->assertViewIs('admin.user-edit-emergency-contact');
        $response->assertViewHas('data');
    }

    /**
     * @test
     * @group update_addr_ok
     */
    public function admin_update_address_returns_an_ok_response()
    {
        $response = $this->actingAs($this->admin_user)
            ->post('admin/user/' . $this->user->id . '/address/edit', [
                'unit' => $this->user->address->unit,
                'street' => $this->user->address->street,
                'city' => $this->user->address->city,
                'province' => $this->user->address->province,
                'postal_code' => $this->user->address->postal_code,
        ]);

        $response->assertRedirect(route('admin_edit_address', $this->user->id));
    }

    /**
     * @test
     * @group update_addr_ok
     */
    public function admin_update_address_validates_with_a_form_request()
    {
        $this->actingAs($this->admin_user)->assertActionUsesFormRequest(
            \App\Http\Controllers\AdminUserController::class,
            'admin_update_address',
            \App\Http\Requests\User\UpdateMemberAddress::class
        );
    }

    /**
     * @test
     * @group update_emerg_ok
     */
    public function admin_update_emergency_contact_returns_an_ok_response()
    {
        $response = $this->actingAs($this->admin_user)
            ->post('admin/user/' . $this->user->id . '/emergency_contact/edit', [
                'emergency_contact_name' => $this->faker->name,
                'emergency_contact_phone' => '6663336666',
                'emergency_contact_relationship' => 'spouse',
                'message' => $this->faker->paragraph
            ]);

        $response->assertRedirect(route('admin_edit_emergency_contact', $this->user->id));
    }

    /**
     * @test
     * @group update_emerg_ok
     */
    public function admin_update_emergency_contact_validates_with_a_form_request()
    {
        $this->actingAs($this->admin_user)->assertActionUsesFormRequest(
            \App\Http\Controllers\AdminUserController::class,
            'admin_update_emergency_contact',
            \App\Http\Requests\Member\UpdateMemberEmergencyContact::class
        );
    }

    /**
     * @test
     * @group
     */
    public function create_returns_an_ok_response()
    {
        $this->markTestIncomplete( __FUNCTION__ .' is not used.');

        $response = $this->actingAs($this->admin_user)
            ->get(route('user_create'));

        $response->assertRedirect(route('users_list'));
    }

    /**
     * @test
     * @group destroyok
     */
    public function destroy_returns_an_ok_response()
    {
       $this->markTestIncomplete( __FUNCTION__ .' has issues.');

        $response = $this->actingAs($this->admin_user)
            ->delete(route('user_destroy', ['ids' => $this->user->id]));

        $this->assertModelMissing($this->user);

        $response->assertRedirect(route('users_list'));
    }

    /**
     * @test
     * @group destroyok
     */
    public function destroy_validates_with_a_form_request()
    {
        $this->actingAs($this->admin_user)->assertActionUsesFormRequest(
            \App\Http\Controllers\AdminUserController::class,
            'destroy',
            \App\Http\Requests\User\DestroyUser::class
        );
    }

    /**
     * @test
     * @group editok
     */
    public function edit_returns_an_ok_response()
    {
        $response = $this->actingAs($this->admin_user)->get(route('user_edit', $this->user));

        $response->assertOk();
        $response->assertViewIs('admin.user');
        $response->assertViewHas('data');
    }

    /**
     * @test
     * @group indexok
     */
    public function index_returns_an_ok_response()
    {
        $response = $this->actingAs($this->admin_user)->get(route('users_list'));

        $response->assertOk();
        $response->assertViewIs('admin.listusers');
        $response->assertViewHas('data');
    }

    /**
     * @test
     * @group storeok
     */
/*    //todo delete method, not used in application
    public function store_returns_an_ok_response()
    {
       $this->markTestIncomplete( __FUNCTION__ .' note used');

        $response = $this->actingAs($this->admin_user)->post('admin/user/create', [
            // TODO: send request data
        ]);

        $response->assertRedirect(route('users_list'));


    }*/

    /**
     * @test
     * @group storeok
     */
    public function store_validates_with_a_form_request()
    {
        $this->actingAs($this->admin_user)->assertActionUsesFormRequest(
            \App\Http\Controllers\AdminUserController::class,
            'store',
            \App\Http\Requests\User\StoreUser::class
        );
    }

    /**
     * @test
     * @group updateok
     */
    public function update_returns_an_ok_response()
    {
      // $this->markTestIncomplete( __FUNCTION__ .' has issues.');

        $user = User::find($this->user->id);

        $response = $this->actingAs($this->admin_user)
            ->post('admin/user/' . $user->id . '/edit', [
            'user' => $user->toArray()
        ]);
        //$response->ddSession()['errors'];
        $response->assertRedirect(route('user_edit', $user->id));
    }

    /**
     * @test
     * @group updateok
     */
    public function update_validates_with_a_form_request()
    {
        $this->actingAs($this->admin_user)->assertActionUsesFormRequest(
            \App\Http\Controllers\AdminUserController::class,
            'update',
            \App\Http\Requests\User\UpdateUser::class
        );
    }


}
