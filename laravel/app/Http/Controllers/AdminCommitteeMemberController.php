<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommitteeMember\DestroyCommitteeMember;
use App\Http\Requests\CommitteeMember\SearchCommitteeMember;
use App\Http\Requests\CommitteeMember\StoreCommitteeMember;
use App\Http\Requests\CommitteeMember\UpdateCommitteeMember;
use App\Models\Committee;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;


class AdminCommitteeMemberController extends Controller
{
    /**
     * @param Committee $committee
     * @return Application|Factory|View
     */
    public function index(Committee $committee)
    {
        $this->authorize('viewAny', Auth::user());
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
     * @return Application|Factory|View
     */
    public function search(SearchCommitteeMember $request, Committee $committee)
    {
        $data = [];
        $data['search'] = User::where('name', 'LIKE', '%'. $request->search .'%')->
            with('committee_memberships')->get();
        $committee->load('active_committee_members')->sortable();
        $data['query'] = $request->search;
        $data['committee'] = $committee;
        $data['committee_roles'] = $this->getFormOptions(['committee_roles']);
        return view('admin.committee_members_list', ['data' => $data]);
    }


    /**
     * @param Committee $committee
     * @param User $user
     * @return Application|Factory|View
     */
    public function create(Committee $committee, User $user)
    {
        $this->authorize('create', Auth::user());
        $data= [];
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
     */
    public function store(StoreCommitteeMember $request, Committee $committee, User $user)
    {
        $this->authorize('create', Auth::user());
        $user->load('committee_memberships');

        $committee->committee_members()->attach($user['id'], ['role' => $request['role']]);

        //todo send email to member

        Session::flash('success', "You have added " . $user->name . " to " . $committee->name);

        return redirect()->route('admin-list-committee-members', [$committee->slug, $user->id]);
    }


    /**
     * @param Committee $committee
     * @param User $user
     * @return Application|Factory|View
     */
    public function edit(Committee $committee, User $user)
    {
        $this->authorize('create', Auth::user());
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
     */
    public function update(UpdateCommitteeMember $request, Committee $committee, User $user)
    {
        $this->authorize('update', Auth::user());
        $user->load('committee_memberships');
        $committee->committee_members()->updateExistingPivot($user['id'], ['role' => $request['role']]);

        //todo send email to member

        Session::flash('success', "You have updated " . $user->name . " in " . $committee->name);

        return redirect()->route('admin-list-committee-members', [$committee->slug, $user->id]);
    }

    /**
     * @param DestroyCommitteeMember $request
     * @param Committee $committee
     * @param User $user
     * @return RedirectResponse
     */
    public function destroy(DestroyCommitteeMember $request, Committee $committee, User $user)
    {

//todo do I want to hold a history of membership in committees?
        $this->authorize('delete', Auth::user());

        $committee->committee_members()->updateExistingPivot($user['id'],
            ['role' => 'Past-Member']);

        $committee->committee_members()->detach($user['id']);

        Session::flash('success', $user->name . " was deleted from " . $committee->name);

        return redirect()->route('admin-list-committee-members', [$committee->slug]);
    }
}
