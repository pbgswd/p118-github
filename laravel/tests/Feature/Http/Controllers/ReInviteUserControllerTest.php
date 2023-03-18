<?php

namespace Tests\Feature\Http\Controllers;

use Tests\TestCase;

/**
 * @see \App\Http\Controllers\ReInviteUserController
 */
class ReInviteUserControllerTest extends TestCase
{
    /**
     * @test
     */
    public function index_returns_an_ok_response()
    {
        $this->markTestSkipped(__FUNCTION__ .' for reinvite user has not been written yet, has no code');

        $inviteUsers = \App\Models\InviteUser::factory()->times(3)->create();

        $response = $this->get(route('invite-resend-list'));

        $response->assertRedirect(route('admin_list_invited_users'));
    }
}
