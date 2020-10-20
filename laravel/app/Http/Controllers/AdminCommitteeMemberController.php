<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommitteeMember\SearchCommitteeMember;
use App\Http\Requests\CommitteeMember\StoreCommitteeMember;
use App\Models\Committee;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
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


    public function search(SearchCommitteeMember $request, Committee $committee)
    {
        $data = [];
        $data['search'] = User::where('name', 'LIKE', '%'.$request->search.'%')->
            with('committee_memberships')->get();
        $committee->load('active_committee_members')->sortable();
        $data['committee'] = $committee;
        $data['committee_roles'] = $this->getFormOptions(['committee_roles']);
        return view('admin.committee_members_list', ['data' => $data]);
    }


    /**
     * @param Committee $committee
     * @param User $user
     */
    public function create(Committee $committee, User $user)
    {
        $this->authorize('create', Auth::user());
        $data= [];
        $data['committee'] = $committee;
        $data['committee_roles'] = $this->getFormOptions(['committee_roles']);
        $data['user'] = $user;

        //todo redirect user if already in this committee and active

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
        dd($request->all());


        $this->authorize('create', Auth::user());
        foreach ($request->members as $member)
        {
            if(!empty($member['id'])) {
                $committee->committee_members()->attach($member['id'], ['role' => $member['role']]);
            }
        }

        Session::flash('success', "You have added " . count($request->members)
            . " members to committee " . $committee->name);
        return redirect()->route('list-bulk-add', $request->committee['slug']);
    }

    /**
     * Display the specified resource.
     *
     * @param User $user
     * @return Response
     */
    public function show(User $user)
    {
        //todo methods to admin show list of members of a committee
    }

    /**
     * @param User $user
     */
    public function edit(User $user)
    {
        //todo methods and request validators for editing users in committees
        $this->authorize('update', Auth::user());
    }

    /**
     * @param Request $request
     */
    public function update(Request $request)
    {
        //todo methods and request validators for updating users in committees
        $this->authorize('update', Auth::user());
    }

    /**
     * @param User $user
     */
    public function destroy(User $user)
    {
        //todo methods and request validators for deleting users in committees
        $this->authorize('delete', Auth::user());
    }
}
