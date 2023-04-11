<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Address;
use App\Models\Committee;
use App\Models\Membership;
use App\Models\PhoneNumber;
use App\Models\User;
use App\Models\UserInfo;
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
        $committee = Committee::factory()->create();

        $user = User::factory()
            ->has(UserInfo::factory(), 'user_info')
            ->has(PhoneNumber::factory(), 'phone_number')
            ->has(Membership::factory(),'membership')
            ->has(Address::factory(), 'address')
            ->create();

        $user->assignRole('member');

        $response = $this->actingAs($this->admin_user)
            ->get(route('admin_create_committee_members', [$committee, $user]));

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
        $committee = Committee::factory()->create();

        $user = User::factory()
            ->has(Membership::factory(),'membership')
            ->create();
        $user->assignRole('member');

        $response = $this->actingAs($this->admin_user)
            ->post(route('admin_create_committee_members', [$committee, $user]),
                [
                    'role' => 'Chair'
                ]);

        //todo delete member from committee, then prove it

        $response = $this->actingAs($this->admin_user)
            ->delete(route('admin_delete-committee_member', [$committee, $user->id]));

       $response->assertRedirect(route('admin-list-committee-members', [$committee->slug]));

        $this->assertModelMissing($user->id);
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
        $committee = Committee::factory()->create();

        $user = User::factory()
            ->has(Membership::factory(),'membership')
            ->create();

        $user->assignRole('member');

        $response = $this->actingAs($this->admin_user)
            ->post(route('admin_create_committee_members', [$committee, $user]),
                [
                    'role' => 'Chair'
                ]);
        // user is now a member of the committee

        $response = $this->get(route('admin_edit_committee_members', [$committee, $user]));

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
        $committee = Committee::factory()->create();

        $response = $this->actingAs($this->admin_user)
            ->get(route('admin-list-committee-members', [$committee]));

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
        $committee = Committee::factory()->create();

        $response = $this->actingAs($this->admin_user)
            ->post(route('admin_search_committee_members', $committee),
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
        $committee = Committee::factory()->create();

        $user = User::factory()
            ->has(Membership::factory(),'membership')
            ->create();

        $user->assignRole('member');

        $response = $this->actingAs($this->admin_user)
            ->post(route('admin_create_committee_members', [$committee, $user]),
            [
                'role' => 'Chair'
            ]);

        $response->assertRedirect(route('admin-list-committee-members', [$committee->slug, $user->id]));
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
        $committee = Committee::factory()->create();
        $user = User::factory()
            ->has(Membership::factory(),'membership')
            ->create();
        $user->assignRole('member');

        $response = $this->actingAs($this->admin_user)
            ->post(route('admin_update_committee_member', [$committee, $user]),
                [
                    'role' => 'Member'
                ]);

        $response->assertRedirect(route('admin-list-committee-members', [$committee->slug, $user->id]));
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
