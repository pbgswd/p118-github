<?php

namespace App\Http\Controllers;

use App\Http\Requests\Committees\DestroyCommittee;
use App\Http\Requests\Committees\StoreCommitteeRequest;
use App\Http\Requests\Committees\UpdateCommittee;
use App\Models\Committee;
use App\Models\Options;
use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\View\View;

class AdminCommitteeController extends Controller
{
    /**
     * @return Factory|View
     */
    public function index()
    {
        $this->authorize('viewAny', Auth::user());
        $c = Committee::with('creator')->sortable()->paginate(10);

        return view('admin.listcommittees', ['data' => array('committees' => $c)]);
    }

    /**
     * @return Factory|View
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
     * @param StoreCommitteeRequest $request
     *
     * @return RedirectResponse
     */
    public function store(StoreCommitteeRequest $request): RedirectResponse
    {
        $this->authorize('create', Auth::user());

        $data = $request->committee;
        $data['user_id'] = Auth::id();
        $committee = new Committee($data);
        $committee->save();

        Session::flash('success', "You have saved a new committee, " . $committee->name);

        return redirect()->route('committee_show', $committee->slug);
    }

    /**
     * @param Committee $committee
     * @param User $users
     *
     * @return Factory|View
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
     *
     * @return Factory|View
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
     *
     * @return RedirectResponse
     */
    public function update(UpdateCommittee $request, Committee $committee): RedirectResponse
    {
        $this->authorize('update', Auth::user());
        $committee->fill($request->committee);
        $committee->save();

        Session::flash('success', "You have updated committee " . $committee->name);

        return redirect()->route('committee_edit', $committee->slug);
    }

    /**
     * @param DestroyCommittee $request
     *
     * @return RedirectResponse
     */
    public function destroy(DestroyCommittee $request): RedirectResponse
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
