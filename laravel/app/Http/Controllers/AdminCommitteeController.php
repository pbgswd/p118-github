<?php

namespace App\Http\Controllers;

use App\Http\Requests\Committees\DestroyCommitteeRequest;
use App\Http\Requests\Committees\StoreCommitteeRequest;
use App\Http\Requests\Committees\UpdateCommitteeRequest;
use App\Models\Committee;
use App\Models\Options;
use App\Models\User;
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
        $c = Committee::withoutGlobalScopes()->with('creator')->sortable()->paginate(10);

        return view('admin.listcommittees', ['data' => ['committees' => $c]]);
    }

    /**
     * @return Factory|View
     */
    public function create()
    {
        $this->authorize('create', Auth::user());

        $data = [
            'user_id' => Auth::id(),
            'committee' => new Committee,
        ];

        return view('admin.committee', ['data' => [
            'data' => $data,
            'access_levels' => $this->getFormOptions(['access_levels']),
            'action' => 'Create',]
        ]);
    }

    /**
     * @param StoreCommitteeRequest $request
     *
     * @return RedirectResponse
     */
    public function store(StoreCommitteeRequest $request): RedirectResponse
    {
        $this->authorize('create', Auth::user());

        $committee = New Committee($request->input('committee'));
        $committee->user_id = Auth::id();
        $committee->save();

        Session::flash('success', "You have saved a new committee, " . $committee->name);

        return redirect()->route('committee_show', $committee->slug);
    }

    /**
     * @param Committee $committee
     * @param User $users
     * @return Factory|View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(Committee $committee, User $users)
    {
        $this->authorize('create', Auth::user());

        $committee->load('creator', 'committee_members');

        $committee['member_count'] = $committee->committee_members->count();
        $committee['post_count'] = $committee->posts->count();
        $committee['committee_roles'] = Options::committee_roles();

        $committee_executive_roles = Options::committee_executive_roles();

        $committee['executives'] = $committee->committee_members->filter(
            function (User $user) use ($committee_executive_roles) {
                return in_array($user->pivot->role, $committee_executive_roles);
            })
            ->sortBy(
                function (User $user) use ($committee_executive_roles) {
                    return array_search($user->pivot->role, $committee_executive_roles);
                });

        return view('admin.show_committee', ['data' => [
                'committee' => $committee,
                'action' => 'View',
            ]
        ]);
    }

    /**
     * @param Committee $any_committee
     * @return Factory|View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(Committee $any_committee)
    {
        $this->authorize('create', Auth::user());

        $any_committee->load('creator','committee_members');
        $any_committee['member_count'] = count($any_committee->committee_members);
        $data = ['committee' => $any_committee];
        $access_levels = $this->getFormOptions(['access_levels']);

        return view('admin.committee', ['data' => [
            'data' => $data,
            'access_levels' => $access_levels,
            'action' => 'Edit',
            ]
        ]);
    }

    /**
     * @param UpdateCommitteeRequest $request
     * @param Committee $any_committee
     * @return RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(UpdateCommitteeRequest $request, Committee $any_committee): RedirectResponse
    {
        $this->authorize('update', Auth::user());
        $any_committee->fill($request->committee);
        $any_committee->save();

        Session::flash('success', "You have updated committee " . $any_committee->name);

        return redirect()->route('committee_edit', $any_committee->slug);
    }

    /**
     * @param DestroyCommitteeRequest $request
     *
     * @return RedirectResponse
     */
    public function destroy(DestroyCommitteeRequest $request): RedirectResponse
    {
        $this->authorize('delete', Auth::user());

        Committee::withoutGlobalScopes()
            ->find($request->id)
            ->each(function (Committee $committee) {
                //todo committee set to... archive?
                //todo committee destroy committee relation?
                //todo committee destroy committee posts?
                //todo committee delete members?

                $committee->delete();
            });

        Session::flash('success', Str::plural('Committee', count($request->id)) . ' deleted.');

        return redirect()->route('committees_list');
    }
}
