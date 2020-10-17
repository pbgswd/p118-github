<?php

namespace App\Http\Controllers;

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
        /** @var Collection $users */
        $users = User::with('committee_memberships')->sortable()->paginate(20);

        $data = [];
        $data['users'] = $users->map(static function (User $user) use ($committee) {
            $info = $user->toArray();
            $info['isMember'] = $user->committee_memberships
                ->contains(static function (Committee $membership) use ($committee) {
                return $membership->slug === $committee->slug;
            });
            return $info;
        });

        $data['committee'] = $committee;
        $data['committee_roles'] = $this->getFormOptions(['committee_roles']);

        return view('admin.committeebulkaddusers', ['data' => $data, 'users' => $users]);
    }

    /**
     *
     */
    public function create()
    {
        $this->authorize('create', Auth::user());
    }

    /**
     * @param Request $request
     * @param Committee $committee
     * @return RedirectResponse
     */
    public function store(Request $request, Committee $committee)
    {
        //todo form request work for committee member controller
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
