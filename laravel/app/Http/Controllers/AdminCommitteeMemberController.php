<?php

namespace App\Http\Controllers;

use App\Models\Committee;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;


class AdminCommitteeMemberController extends Controller
{
    /**
     * @param Request $request
     * @param Committee $committee
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Request $request, Committee $committee)
    {
        $this->authorize('viewAny', Auth::user());
        /** @var Collection $users */
        $users = User::sortable()->with('committee_memberships')->paginate(20);

        $data = [];
        $data['users'] = $users->map(static function (User $user) use ($committee) {
            $info = $user->toArray();
            $info['isMember'] = $user->committee_memberships->contains(static function (Committee $membership) use ($committee) {
                return $membership->slug === $committee->slug;
            });
            return $info;
        });

        $data['committee'] = $committee;
        $data['committee_roles'] = $this->getFormOptions(['committee_roles']);

        return view('admin.committeebulkaddusers', ['data' => $data, 'users' => $users]);
    }

    /**
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create()
    {
        $this->authorize('create', Auth::user());
    }

    /**
     * @param Request $request
     * @param Committee $committee
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(Request $request, Committee $committee)
    {
        //dd($request->all());
        $this->authorize('create', Auth::user());
        foreach ($request->members as $member)
        {
            dd(array_keys($member));
           $committee->committee_members()->attach($member['id'], ['role' => $member['role']]);
        }

        Session::flash('success', "You have added " . count($request->members) . " members to committee " . $committee->name);
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
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(User $user)
    {
        //todo methods and request validators for editing users in committees
        $this->authorize('update', Auth::user());
    }

    /**
     * @param Request $request
     * @param User $user
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(Request $request, User $user)
    {
        //todo methods and request validators for updating users in committees
        $this->authorize('update', Auth::user());
    }

    /**
     * @param User $user
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(User $user)
    {
        //todo methods and request validators for deleting users in committees

        $this->authorize('delete', Auth::user());
    }
}
