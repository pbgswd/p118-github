<?php

namespace Tests\Feature\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\ReInviteUserController
 */
class ReInviteUserControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function index_returns_an_ok_response()
    {
        $this->markTestIncomplete( __FUNCTION__ .' has issues.');

        $inviteUsers = \App\Models\InviteUser::factory()->times(3)->create();

        $response = $this->get(route('invite-resend-list'));

        $response->assertRedirect(route('admin_list_invited_users'));


    }


}
