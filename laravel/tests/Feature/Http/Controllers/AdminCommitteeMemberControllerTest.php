<?php

namespace Tests\Feature\Http\Controllers;

use Tests\TestCase;

/**
 * @see \App\Http\Controllers\AdminCommitteeMemberController
 */
class AdminCommitteeMemberControllerTest extends TestCase
{


    /**
     * @test
     */
    public function create_returns_an_ok_response()
    {
        $this->markTestIncomplete( __FUNCTION__ .' has issues.');

        $committee = \App\Models\Committee::factory()->create();
        $user = \App\Models\User::factory()->create();

        $response = $this->get(route('admin_create_committee_members', [$committee, $user]));

        $response->assertOk();
        $response->assertViewIs('admin.committee_manage_membership');
        $response->assertViewHas('data');


    }

    /**
     * @test
     */
    public function destroy_returns_an_ok_response()
    {
        $this->markTestIncomplete( __FUNCTION__ .' has issues.');

        $committee = \App\Models\Committee::factory()->create();
        $user = \App\Models\User::factory()->create();

        $response = $this->delete(route('admin_delete-committee_member', [$committee, $user]));

        $response->assertRedirect(route('admin-list-committee-members', [$committee->slug]));
        $this->assertModelMissing($user);


    }

    /**
     * @test
     */
    public function destroy_validates_with_a_form_request()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\AdminCommitteeMemberController::class,
            'destroy',
            \App\Http\Requests\CommitteeMember\DestroyCommitteeMember::class
        );
    }

    /**
     * @test
     */
    public function edit_returns_an_ok_response()
    {
        $this->markTestIncomplete( __FUNCTION__ .' has issues.');

        $committee = \App\Models\Committee::factory()->create();
        $user = \App\Models\User::factory()->create();

        $response = $this->get(route('admin_edit_committee_members', [$committee, $user]));

        $response->assertOk();
        $response->assertViewIs('admin.committee_manage_membership');
        $response->assertViewHas('data');


    }

    /**
     * @test
     */
    public function index_returns_an_ok_response()
    {
        $this->markTestIncomplete( __FUNCTION__ .' has issues.');

        $committee = \App\Models\Committee::factory()->create();

        $response = $this->get(route('admin-list-committee-members', [$committee]));

        $response->assertOk();
        $response->assertViewIs('admin.committee_members_list');
        $response->assertViewHas('data');


    }

    /**
     * @test
     */
    public function search_returns_an_ok_response()
    {
        $this->markTestIncomplete( __FUNCTION__ .' has issues.');

        $committee = \App\Models\Committee::factory()->create();
        $users = \App\Models\User::factory()->times(3)->create();

        $response = $this->post('admin/committee/{committee}/admin-list-committee-members', [
            // TODO: send request data
        ]);

        $response->assertOk();
        $response->assertViewIs('admin.committee_members_list');
        $response->assertViewHas('data');


    }

    /**
     * @test
     */
    public function search_validates_with_a_form_request()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\AdminCommitteeMemberController::class,
            'search',
            \App\Http\Requests\CommitteeMember\SearchCommitteeMember::class
        );
    }

    /**
     * @test
     */
    public function store_returns_an_ok_response()
    {
        $this->markTestIncomplete( __FUNCTION__ .' has issues.');

        $committee = \App\Models\Committee::factory()->create();
        $user = \App\Models\User::factory()->create();

        $response = $this->post('admin/committee/{committee}/admin-create-committee-members/user/{user}', [
            // TODO: send request data
        ]);

        $response->assertRedirect(route('admin-list-committee-members', [$committee->slug, $user->id]));


    }

    /**
     * @test
     */
    public function store_validates_with_a_form_request()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\AdminCommitteeMemberController::class,
            'store',
            \App\Http\Requests\CommitteeMember\StoreCommitteeMember::class
        );
    }

    /**
     * @test
     */
    public function update_returns_an_ok_response()
    {
        $this->markTestIncomplete( __FUNCTION__ .' has issues.');

        $committee = \App\Models\Committee::factory()->create();
        $user = \App\Models\User::factory()->create();

        $response = $this->post('admin/committee/{committee}/admin-edit-committee-members/user/{user}', [
            // TODO: send request data
        ]);

        $response->assertRedirect(route('admin-list-committee-members', [$committee->slug, $user->id]));


    }

    /**
     * @test
     */
    public function update_validates_with_a_form_request()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\AdminCommitteeMemberController::class,
            'update',
            \App\Http\Requests\CommitteeMember\UpdateCommitteeMember::class
        );
    }


}
