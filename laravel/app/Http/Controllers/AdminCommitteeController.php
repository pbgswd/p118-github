<?php

namespace App\Http\Controllers;

use App\Http\Requests\Committees\DestroyCommittee;
use App\Http\Requests\Committees\StoreCommittee;
use App\Http\Requests\Committees\UpdateCommittee;
use App\Models\Committee;
use App\Models\Options;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class AdminCommitteeController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index()
    {
        $this->authorize('viewAny', Auth::user());
        $c = Committee::with('creator')->sortable()->paginate(10);

        return view('admin.listcommittees', ['data' => array('committees' => $c)]);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create()
    {
        $this->authorize('create', Auth::user());

        $committee = new Committee;
        $access_levels = $this->getFormOptions(['access_levels']);
        $data = [
            'user_id' => Auth::id(),
            'committee' => $committee,
        ];

        return view('admin.committee', ['data' => ['data' => $data, 'access_levels' => $access_levels, 'action' => 'Create']]);
    }

    /**
     * @param StoreCommittee $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(StoreCommittee $request)
    {
        $this->authorize('create', Auth::user());

        $data = $request->input('committee');
        $data['user_id'] = Auth::id();
        $committee = new Committee($data);
        $committee->save();

        Session::flash('success', "You have saved a new committee, " . $committee->name);

        return redirect()->route('committee_show', $committee->slug);
    }

    /**
     * @param Committee $committee
     * @param User $users
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(Committee $committee, User $users)
    {
        $this->authorize('create', Auth::user());

        $committee->load('creator', 'committee_members');

        $committee['member_count'] = count($committee->committee_members);
        $committee['post_count'] = count($committee->posts);

        $committee['committee_roles'] = Options::committee_roles();
        $committee_executive_roles = Options::committee_executive_roles();

        $committee['executives'] = $committee->committee_members->filter( function (User $user) use ($committee_executive_roles) {
            return in_array($user->pivot->role, $committee_executive_roles);
        })
        ->sortBy( function (User $user) use ($committee_executive_roles) {
            return array_search($user->pivot->role, $committee_executive_roles);
        });

        return view('admin.show_committee', ['data' => ['committee' => $committee, 'action' => 'View']]);
    }

    /**
     * @param Committee $committee
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(Committee $committee)
    {
        $this->authorize('create', Auth::user());

        $committee->creator;
        $committee->committee_members;
        $committee['member_count'] = count($committee->committee_members);
        $data = ['committee' => $committee];
        $access_levels = $this->getFormOptions(['access_levels']);

        return view('admin.committee', ['data' => ['data' => $data, 'access_levels' => $access_levels, 'action' => 'Edit']]);
    }

    /**
     * @param UpdateCommittee $request
     * @param Committee $committee
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(UpdateCommittee $request, Committee $committee)
    {
        $this->authorize('update', Auth::user());
        $committee->fill($request->committee);
        $committee->save();

        Session::flash('success', "You have updated committee " . $committee->name);

        return redirect()->route('committee_edit', $committee->slug);
    }

    /**
     * @param DestroyCommittee $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(DestroyCommittee $request)
    {
        $this->authorize('delete', Auth::user());
        // set to... archive?
        // destroy committee relation?
        // destroy committee posts?
        // delete members?

        Committee::destroy($request->id);

        Session::flash('success', Str::plural('Committee', count($request->id)) . ' deleted.');

        return redirect()->route('committees_list');
    }
}
