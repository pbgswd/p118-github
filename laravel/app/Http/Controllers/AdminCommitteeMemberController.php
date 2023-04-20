<?php

namespace App\Http\Controllers;

use App\Constants\CommitteeConstants;
use App\Http\Requests\CommitteeMember\DestroyCommitteeMember;
use App\Http\Requests\CommitteeMember\SearchCommitteeMember;
use App\Http\Requests\CommitteeMember\StoreCommitteeMember;
use App\Http\Requests\CommitteeMember\UpdateCommitteeMember;
use App\Models\Committee;
use App\Models\Options;
use App\Models\User;
use App\Services\EmailCommitteeMembershipService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

class AdminCommitteeMemberController extends Controller
{
    private $emailCommitteeMembershipService;

    public function __construct(EmailCommitteeMembershipService $emailCommitteeMembershipService)
    {
        $this->emailCommitteeMembershipService = $emailCommitteeMembershipService;
    }

    /**
     * @param Committee $committee
     * @return View
     * @throws AuthorizationException
     */
    public function index(Committee $committee): View
    {

        $this->authorize('update', $committee);
        $data = [];

        $committee->load('active_committee_members')->sortable();

        $data['committee'] = $committee;

        $data['committee_roles'] = $this->getFormOptions(['committee_roles']);
        $data['search'] = [];

        return view('admin.committee_members_list', ['data' => $data]);
    }

    /**
     * @param SearchCommitteeMember $request
     * @param Committee $committee
     * @return View
     * @throws AuthorizationException
     */
    public function search(SearchCommitteeMember $request, Committee $committee): View
    {
        $this->authorize('update', $committee);

        $data = [];

        $data['search'] = User::where('name', 'LIKE', '%'.filter_var($request->search, FILTER_SANITIZE_STRING).'%')
            ->with(
                ['committee_memberships' => function ($query) use ($committee) {
                    $query->where('committee_id', $committee->id);
                }]
            )
            ->get();

        $committee->load('active_committee_members')->sortable();

        $data['query'] = $request->search;
        $data['committee'] = $committee;
        $data['committee_roles'] = $this->getFormOptions(['committee_roles']);

        return view('admin.committee_members_list', ['data' => $data]);
    }

    /**
     * @param Committee $committee
     * @param User $user
     * @return View
     *
     * @throws AuthorizationException
     */
    public function create(Committee $committee, User $user): View
    {
        $this->authorize('update', $committee);
        $data = [];
        $data['committee'] = $committee;
        $data['committee_roles'] = $this->getFormOptions(['committee_roles']);
        $data['user'] = $user;
        $data['action'] = 'Add';

        return view('admin.committee_manage_membership', ['data' => $data]);
    }

    /**
     * @param StoreCommitteeMember $request
     * @param Committee $committee
     * @param User $user
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function store(StoreCommitteeMember $request, Committee $committee, User $user): RedirectResponse
    {
        $this->authorize('update', $committee);

        $user->load('committee_memberships');

        $committee->committee_members()->attach($user['id'], ['role' => $request['role']]);

        if (in_array($request['role'], Options::committee_executive_roles())) {
            $user->assignRole(CommitteeConstants::COMMITTEE);
        }

        $data['role'] = $request['role'];
        $data['committee'] = $committee;
        $data['user'] = $user;

        $result = $this->emailCommitteeMembershipService->sendMessage($data);

        Session::flash('success', 'You have added '.$user->name.' to '.$committee->name.
            'An email notification has been sent.');

        return redirect()->route('admin-list-committee-members', [$committee->slug, $user->id]);
    }

    /**
     * @param Committee $committee
     * @param User $user
     * @return View
     * @throws AuthorizationException
     */
    public function edit(Committee $committee, User $user): View
    {
        $this->authorize('update', $committee);

        $user->load(['committee_memberships' => function ($query) use ($committee) {
            $query->where('committee_id', $committee->id);
        }]);

        $this->authorize('update', $committee);

        $data = [];
        $data['committee'] = $committee;
        $data['committee_roles'] = $this->getFormOptions(['committee_roles']);
        $data['user'] = $user;
        $data['action'] = 'Edit';

        return view('admin.committee_manage_membership', ['data' => $data]);
    }

    /**
     * @param UpdateCommitteeMember $request
     * @param Committee $committee
     * @param User $user
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function update(UpdateCommitteeMember $request, Committee $committee, User $user): RedirectResponse
    {
        $this->authorize('update', $committee);

        $user->load('committee_memberships');

        $committee->committee_members()->updateExistingPivot($user['id'], ['role' => $request['role']]);

        /**
         * get all roles of user
         * assign user to committee, add admin role if role assigned is executive
         * if user is exec in another committee, user may keep that role.
         */
        $keepRole = 0;

        foreach ($user->committee_memberships as $m) {
            if (in_array($m->pivot->role, Options::committee_executive_roles()) &&
                    $committee->id != $m->pivot->committee_id) {
                $keepRole = 1;
            }
        }

        if (in_array($request['role'], Options::committee_executive_roles())) {
            $user->assignRole(CommitteeConstants::COMMITTEE);
        } else {
            if ($keepRole == 0 && ! in_array($request['role'], Options::committee_executive_roles())) {
                $user->removeRole(CommitteeConstants::COMMITTEE);
            }
        }

        if ($request['role'] != 'Past Member') {
            $data['role'] = $request['role'];
            $data['committee'] = $committee;
            $data['user'] = $user;

            $result = $this->emailCommitteeMembershipService->sendMessage($data);
        }

        Session::flash('success', 'You have updated '.$user->name.' in '.$committee->name);

        return redirect()->route('admin-list-committee-members', [$committee->slug, $user->id]);
    }

    /**
     * @param DestroyCommitteeMember $request
     * @param Committee $committee
     * @param User $user
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function destroy(DestroyCommitteeMember $request, Committee $committee, User $user): RedirectResponse
    {
//todo prove unit test is going in this method AdminCommitteeMemberControllerTest::destroy_returns_an_ok_response
        $this->authorize('update', $committee);
        Log::debug(['slug' => $committee->slug, 'user' => $user->id ]);
dd(999);
        //  $committee->committee_members()->updateExistingPivot($user['id'],['role' => 'Past-Member']);

        $committee->committee_members()->detach($user['id']);
//dd(99);
        Session::flash('success', $user->name.' was deleted from '.$committee->name);

        return redirect()->route('admin-list-committee-members', [$committee->slug]);
    }
}
