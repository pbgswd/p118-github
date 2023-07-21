<?php

namespace Tests\Feature\Http\Controllers;

use Illuminate\Support\Facades\Log;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\AdminCommitteeMemberController
 */
class AdminCommitteeMemberControllerTest extends TestCase
{

    /**
     * @test
     * @group createok
     */
    public function create_returns_an_ok_response()
    {
        $response = $this->actingAs($this->admin_user)
            ->get(route('admin_create_committee_members', [$this->committee, $this->user]));

        $response->assertOk();
        $response->assertViewIs('admin.committee_manage_membership');
        $response->assertViewHas('data');
    }

    /**
     * @test
     * @group destroyok
     */
    public function destroy_returns_an_ok_response()
    {
 //todo get a user associated with the committee - know a user id and send it in
//dd($this->committee->committee_members[0]->id);
        Log::debug(['slug' => $this->committee->slug, 'user' => $this->committee->committee_members[0]->id ]);
//todo supposed to be going in AdminCommitteeControllerMethod::destroy

        $response = $this->actingAs($this->admin_user)
            ->delete(route('admin_delete-committee_member',
                [
                    'committee' => $this->committee->slug,
                    'user' => $this->committee->committee_members[0]->id
                ]
            ));

Log::debug(route('admin-list-committee-members', ['committee' => $this->committee->slug]));
// http://p118.dev/admin/committee/anti-racism-committee/admin-edit-committee-members/user/122

        $this->assertModelMissing($this->committee->committee_members);
        $response->assertRedirect(route('admin-list-committee-members', ['committee' => $this->committee->slug]));
    }

    /**
     * @test
     * @group destroyok
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
     * @group editok
     */
    public function edit_returns_an_ok_response()
    {
        $response = $this->actingAs($this->admin_user)
            ->get(route('admin_edit_committee_members', [$this->committee, $this->user]));

        $response->assertOk();
        $response->assertViewIs('admin.committee_manage_membership');
        $response->assertViewHas('data');
    }

    /**
     * @test
     * @group indexok
     */
    public function index_returns_an_ok_response()
    {
        $response = $this->actingAs($this->admin_user)
            ->get(route('admin-list-committee-members', [$this->committee]));

        $response->assertOk();
        $response->assertViewIs('admin.committee_members_list');
        $response->assertViewHas('data');
    }

    /**
     * @test
     * @group searchok
     */
    public function search_returns_an_ok_response()
    {
        $response = $this->actingAs($this->admin_user)
            ->post(route('admin_search_committee_members', $this->committee),
                [
                    'search' => $this->user->name,
                ]);

        $response->assertOk();
        $response->assertViewIs('admin.committee_members_list');
        $response->assertViewHas('data');
    }

    /**
     * @test
     * @group searchok
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
     * @group storeok
     */
    public function store_returns_an_ok_response()
    {
        $response = $this->actingAs($this->admin_user)
            ->post(route('admin_create_committee_members', [$this->committee, $this->user]),
            [
                'role' => 'Member'
            ]);

        $response->assertRedirect(route('admin-list-committee-members', [$this->committee->slug, $this->user->id]));
    }

    /**
     * @test
     * @group storeok
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
     * @group updateok
     */
    public function update_returns_an_ok_response()
    {
        //todo update a member's status
        $response = $this->actingAs($this->admin_user)
            ->post(route('admin_update_committee_member', [$this->committee, $this->committee_member]),
                [
                    'role' => 'Member'
                ]);

        $response->assertRedirect(route('admin-list-committee-members',
            [$this->committee->slug, $this->committee_member->id]));
    }

    /**
     * @test
     * @group updateok
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
