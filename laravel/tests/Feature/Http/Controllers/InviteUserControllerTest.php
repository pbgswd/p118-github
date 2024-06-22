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
     *
     * @group createok
     */
    public function create_returns_an_ok_response(): void
    {
        $response = $this->actingAs($this->admin_user)->get(route('invite-new-user'));
        $response->assertOk();
        $response->assertViewIs('admin.invite_user');
        $response->assertViewHas('data');
    }

    /**
     * @test
     *
     * @group destroyok
     */
    public function destroy_returns_an_ok_response(): void
    {
        $inviteUser = \App\Models\InviteUser::factory()->create();
        $response = $this->actingAs($this->admin_user)
            ->delete(route('invited_user_destroy', ['id' => [$inviteUser->id]]));

        $this->assertModelMissing($inviteUser);
        $response->assertRedirect(route('admin_list_invited_users'));
    }

    /**
     * @test
     */
    public function destroy_validates_with_a_form_request(): void
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
    public function index_returns_an_ok_response(): void
    {
        $inviteUsers = \App\Models\InviteUser::factory()->times(3)->create();
        $response = $this->actingAs($this->admin_user)->get(route('admin_list_invited_users'));
        $response->assertOk();
        $response->assertViewIs('admin.invitations_list');
        $response->assertViewHas('data');
    }

    /**
     * @test
     *
     * @group listimportok
     */
    public function list_import_returns_an_ok_response(): void
    {
        $response = $this->actingAs($this->admin_user)->get(route('list_import'));
        $response->assertOk();
        $response->assertViewIs('admin.invite_list_import');
        $response->assertViewHas('data');
    }

    /**
     * @test
     */
    public function process_import_invitation_returns_an_ok_response(): void
    {
        $response = $this->actingAs($this->admin_user)->get(route('process_import_invitation'));
        $response->assertRedirect(route('list_import'));
    }

    /**
     * @test
     *
     * @group processok
     */
    public function process_user_returns_an_ok_response(): void
    {
        $inviteUser = \App\Models\InviteUser::factory()->create();
        $response = $this->get(route('invite_user_signup', [
            'inviteUser' => $inviteUser->id,
            'password' => $inviteUser->password,
        ])
        );

        $response->assertOk();
        $response->assertViewIs('site_invitation');
        $response->assertViewHas('data');

        $response = $this->post(route('public_process_invitation', [$inviteUser->id, $inviteUser->password]),
            [
                'password' => '1234password1234PASSWORD',
                'password_confirmation' => '1234password1234PASSWORD',
            ]
        );

        $response->assertRedirect(route('login'));
    }

    /**
     * @test
     */
    public function process_user_validates_with_a_form_request(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\InviteUserController::class,
            'process_user',
            \App\Http\Requests\InviteUser\ProcessUserRequest::class
        );
    }

    /**
     * @test
     *
     * @group showinvitationok
     */
    public function show_returns_an_ok_response(): void
    {
        $inviteUser = \App\Models\InviteUser::factory()->create();
        $response = $this->get(route('invite_user_signup', [
            'inviteUser' => $inviteUser->id,
            'password' => $inviteUser->password,
        ])
        );

        $response->assertOk();
        $response->assertViewIs('site_invitation');
        $response->assertViewHas('data');
    }

    /**
     * @test
     *
     * @group storeinvitedok
     */
    public function store_returns_an_ok_response(): void
    {
        $inviteUser = \App\Models\InviteUser::factory()->create();

        $response = $this->actingAs($this->admin_user)->post(route('store_invited_user'), [
            'invite' => $inviteUser->toArray(),
        ]);

        $response->assertRedirect(route('admin_list_invited_users'));
    }

    /**
     * @test
     */
    public function store_validates_with_a_form_request(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\InviteUserController::class,
            'store',
            \App\Http\Requests\InviteUser\StoreInviteUserRequest::class
        );
    }
}
