<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Address;
use App\Models\Membership;
use App\Models\PhoneNumber;
use App\Models\User;
use App\Models\UserInfo;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\AdminUserController
 */
class AdminUserControllerTest extends TestCase
{
    //

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
        $this->markTestSkipped( __FUNCTION__ .' is not used.');

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
        Log::debug("Start of " . __FUNCTION__);
      // $this->markTestIncomplete( __FUNCTION__ .' has issues.');

        $user = User::factory()
            ->has(UserInfo::factory(), 'user_info')
            ->has(PhoneNumber::factory(), 'phone_number')
            ->has(Membership::factory(),'membership')
            ->has(Address::factory(), 'address')
            ->create();

        $user->assignRole('member');

        Log::debug("In " . __FUNCTION__ .", User id is: " . $user->id);

        $response = $this->actingAs($this->admin_user)
            ->delete(route('user_destroy', ['id' => $user->id]));

        //$this->assertModelMissing($user);

        $response->assertRedirect(route('users_list'));
    }

    /**
     * @test
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
        $user = User::find($this->user->id);

        $user->load(
            'phone_number',
            'user_info',
            'allExecutiveRoles',
            'committee_memberships',
            'membership'
        );

        $user_roles = $user->getRoleNames()->toArray();

        $response = $this->actingAs($this->admin_user)
            ->post(route("user_edit_update", $user->id),
                [
                    'user' => $user->toArray(),
                    'user_phone' => ["phone_number" => $user->phone_number->phone_number],
                    'user_info' => $user->user_info->toArray(),
                    'user_roles' => array_combine($user_roles, $user_roles),
                    'user_membership' => $user->membership->toArray(),
                ]);

        $response->assertRedirect(route('user_edit', $user->id));
    }

    /**
     * @test
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
