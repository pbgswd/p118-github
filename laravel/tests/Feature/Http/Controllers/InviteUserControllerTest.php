<?php

namespace Tests\Feature\Http\Controllers;

use Tests\TestCase;

/**
 * @see \App\Http\Controllers\InviteUserController
 */
class InviteUserControllerTest extends TestCase
{

    /**
     * @test
     */
    public function create_returns_an_ok_response()
    {
        $response = $this->actingAs($this->admin_user)->get(route('invite-new-user'));
        $response->assertOk();
        $response->assertViewIs('admin.invite_user');
        $response->assertViewHas('data');
    }

    /**
     * @test
     */
    public function destroy_returns_an_ok_response()
    {
        $this->markTestIncomplete( __FUNCTION__ .' has issues.');
//todo incomplete, determine what flow is supposed to happen
        $response = $this->actingAs($this->admin_user)->delete(route('invited_user_destroy'));

        $response->assertRedirect(route('admin_list_invited_users'));
        $this->assertModelMissing($invitedUserDestroy);
    }

    /**
     * @test
     */
    public function destroy_validates_with_a_form_request()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\InviteUserController::class,
            'destroy',
            \App\Http\Requests\InviteUser\DestroyInviteUserRequest::class
        );
    }

    /**
     * @test
     */
    public function index_returns_an_ok_response()
    {
        $inviteUsers = \App\Models\InviteUser::factory()->times(3)->create();
        $response = $this->actingAs($this->admin_user)->get(route('admin_list_invited_users'));
        $response->assertOk();
        $response->assertViewIs('admin.invitations_list');
        $response->assertViewHas('data');
    }

    /**
     * @test
     */
    public function list_import_returns_an_ok_response()
    {
        $response = $this->actingAs($this->admin_user)->get(route('list_import'));
        $response->assertOk();
        $response->assertViewIs('admin.invite_list_import');
        $response->assertViewHas('data');
    }

    /**
     * @test
     */
    public function process_import_invitation_returns_an_ok_response()
    {
        $response = $this->actingAs($this->admin_user)->get(route('process_import_invitation'));
        $response->assertRedirect(route('list_import'));
    }

    /**
     * @test
     */
    public function process_user_returns_an_ok_response()
    {
        //todo more work on process user
        /*
         * invited user hits a link, gets site membership
         * not done by admin_user
         */

        $this->markTestIncomplete( __FUNCTION__ .' has issues.');

        $inviteUser = \App\Models\InviteUser::factory()->create();
//todo send request data determine the flow
        $response = $this->actingAs($this->admin_user)->post('site_invitation/{inviteUser}/{password}', [

        ]);

        $response->assertRedirect(route('login'));
    }

    /**
     * @test
     */
    public function process_user_validates_with_a_form_request()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\InviteUserController::class,
            'process_user',
            \App\Http\Requests\InviteUser\ProcessUserRequest::class
        );
    }

    /**
     * @test
     */
    public function show_returns_an_ok_response()
    {
        //todo more work to do, more flow needed, determine what we are doing here
        $this->markTestIncomplete( __FUNCTION__ .' has issues.');

        $inviteUser = \App\Models\InviteUser::factory()->create();
        $user = \App\Models\User::factory()->create();

        $response = $this->actingAs($this->admin_user)
            ->get(route('invite_user_signup', [$inviteUser, 'password' => $inviteUser->password]));

        $response->assertRedirect(route('hello'));
    }

    /**
     * @test
     */
    public function store_returns_an_ok_response()
    {
        //todo more work to do, more flow needed, determine what we are doing here
        $this->markTestIncomplete( __FUNCTION__ .' has issues.');

        $response = $this->post('admin/invite-new-user', [
            // TODO: send request data
        ]);

        $response->assertRedirect(route('admin_list_invited_users'));
    }

    /**
     * @test
     */
    public function store_validates_with_a_form_request()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\InviteUserController::class,
            'store',
            \App\Http\Requests\InviteUser\StoreInviteUserRequest::class
        );
    }
}
