<?php

namespace Tests\Feature\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\AdminUserController
 */
class AdminUserControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function admin_edit_address_returns_an_ok_response()
    {
        $this->markTestIncomplete( __FUNCTION__ .' has issues.');

        $user = \App\Models\User::factory()->create();

        /**
         *   $phone = new PhoneNumber($request->input('user_phone'));
         *
        $user->phone_number()->save($phone);
         */
//todo user_info

        // todo user_address


        $response = $this->get(route('admin_edit_address', [$user]));

        $response->assertOk();
        $response->assertViewIs('admin.user-edit-address');
        $response->assertViewHas('data');

        // TODO: perform additional assertions
    }

    /**
     * @test
     */
    public function admin_edit_emergency_contact_returns_an_ok_response()
    {
        $this->markTestIncomplete( __FUNCTION__ .' has issues.');

        $user = \App\Models\User::factory()->create();

        $response = $this->get(route('admin_edit_emergency_contact', [$user]));

        $response->assertOk();
        $response->assertViewIs('admin.user-edit-emergency-contact');
        $response->assertViewHas('data');

        // TODO: perform additional assertions
    }

    /**
     * @test
     */
    public function admin_update_address_returns_an_ok_response()
    {
        $this->markTestIncomplete( __FUNCTION__ .' has issues.');

        $user = \App\Models\User::factory()->create();

        $response = $this->post('admin/user/{user}/address/edit', [
            // TODO: send request data
        ]);

        $response->assertRedirect(route('admin_edit_address', $user->id));

        // TODO: perform additional assertions
    }

    /**
     * @test
     */
    public function admin_update_address_validates_with_a_form_request()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\AdminUserController::class,
            'admin_update_address',
            \App\Http\Requests\User\UpdateMemberAddress::class
        );
    }

    /**
     * @test
     */
    public function admin_update_emergency_contact_returns_an_ok_response()
    {
        $this->markTestIncomplete( __FUNCTION__ .' has issues.');

        $user = \App\Models\User::factory()->create();

        $response = $this->post('admin/user/{user}/emergency_contact/edit', [
            // TODO: send request data
        ]);

        $response->assertRedirect(route('admin_edit_emergency_contact', $user->id));

        // TODO: perform additional assertions
    }

    /**
     * @test
     */
    public function admin_update_emergency_contact_validates_with_a_form_request()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\AdminUserController::class,
            'admin_update_emergency_contact',
            \App\Http\Requests\Member\UpdateMemberEmergencyContact::class
        );
    }

    /**
     * @test
     */
    public function create_returns_an_ok_response()
    {
        $this->markTestIncomplete( __FUNCTION__ .' has issues.');

        $response = $this->get(route('user_create'));

        $response->assertRedirect(route('users_list'));

        // TODO: perform additional assertions
    }

    /**
     * @test
     */
    public function destroy_returns_an_ok_response()
    {
        $this->markTestIncomplete( __FUNCTION__ .' has issues.');

        $user = \App\Models\User::factory()->create();
        $userInfo = \App\Models\UserInfo::factory()->create();
        $executiveMembership = \App\Models\ExecutiveMembership::factory()->create();

        $response = $this->delete(route('user_destroy'));

        $response->assertRedirect(route('users_list'));
        $this->assertDeleted($userDestroy);

        // TODO: perform additional assertions
    }

    /**
     * @test
     */
    public function destroy_validates_with_a_form_request()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\AdminUserController::class,
            'destroy',
            \App\Http\Requests\User\DestroyUser::class
        );
    }

    /**
     * @test
     */
    public function edit_returns_an_ok_response()
    {
        $this->markTestIncomplete( __FUNCTION__ .' has issues.');

        $user = \App\Models\User::factory()->create();
        $executives = \App\Models\Executive::factory()->times(3)->create();

        $response = $this->get(route('user_edit', [$user]));

        $response->assertOk();
        $response->assertViewIs('admin.user');
        $response->assertViewHas('data');

        // TODO: perform additional assertions
    }

    /**
     * @test
     */
    public function index_returns_an_ok_response()
    {
        $this->markTestIncomplete( __FUNCTION__ .' has issues.');

        $users = \App\Models\User::factory()->times(3)->create();

        $response = $this->get(route('users_list'));

        $response->assertOk();
        $response->assertViewIs('admin.listusers');
        $response->assertViewHas('data');

        // TODO: perform additional assertions
    }

    /**
     * @test
     */
    public function store_returns_an_ok_response()
    {
        $this->markTestIncomplete( __FUNCTION__ .' has issues.');

        $response = $this->post('admin/user/create', [
            // TODO: send request data
        ]);

        $response->assertRedirect(route('users_list'));

        // TODO: perform additional assertions
    }

    /**
     * @test
     */
    public function store_validates_with_a_form_request()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\AdminUserController::class,
            'store',
            \App\Http\Requests\User\StoreUser::class
        );
    }

    /**
     * @test
     */
    public function update_returns_an_ok_response()
    {
        $this->markTestIncomplete( __FUNCTION__ .' has issues.');

        $user = \App\Models\User::factory()->create();

        $response = $this->post(route('user_edit_update', [$user]), [
            // TODO: send request data
        ]);

        $response->assertRedirect(route('user_edit', [$user->id]));

        // TODO: perform additional assertions
    }

    /**
     * @test
     */
    public function update_validates_with_a_form_request()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\AdminUserController::class,
            'update',
            \App\Http\Requests\User\UpdateUser::class
        );
    }

    // test cases...
}
