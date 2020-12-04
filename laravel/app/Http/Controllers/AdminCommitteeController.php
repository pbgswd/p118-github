<?php

namespace App\Http\Controllers;

use App\Http\Requests\Committees\DestroyCommitteeRequest;
use App\Http\Requests\Committees\StoreCommitteeRequest;
use App\Http\Requests\Committees\UpdateCommitteeRequest;
use App\Models\Committee;
use App\Models\Options;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\View\View;

class AdminCommitteeController extends Controller
{
    /**
     * @return Application|Factory|View
     */
    public function index()
    {
        $this->authorize('viewAny', Committee::class);
        $c = Committee::withoutGlobalScopes()->with('creator')->sortable()->paginate(10);

        $m = null;
        $user = Auth::user();
        if ($user->hasPermissionTo('manage committee')
        ) {
            $m = $user->committee_memberships;
        }

        return view('admin.listcommittees', ['data' => ['committees' => $c, 'manage committees' => $m]]);
    }

    /**
     * @return Application|Factory|View
     */
    public function create()
    {
        $this->authorize('create', Committee::class);

        $data = [
            'user_id' => Auth::id(),
            'committee' => new Committee,
            'access_levels' => Options::access_levels(),
            'action' => 'Create',
        ];

        return view('admin.committee', ['data' => $data]);
    }

    /**
     * @param StoreCommitteeRequest $request
     * @return RedirectResponse
     */
    public function store(StoreCommitteeRequest $request): RedirectResponse
    {
        $this->authorize('create', Committee::class);

        $committee = New Committee($request->input('committee'));
        $committee->user_id = Auth::id();
        $committee->save();

        Session::flash('success', "You have created a new committee, " . $committee->name);

        return redirect()->route('admin_committee_show', $committee->slug);
    }

    /**
     * @param Committee $committee
     * @return Factory|View
     */
    public function show(Committee $committee)
    {
        $this->authorize('view', $committee);

        $committee->load('creator', 'active_committee_members');

        $committee['post_count'] = $committee->posts->count();
        $committee['committee_roles'] = Options::committee_roles();
        $committee_executive_roles = Options::committee_executive_roles();

        $user = $committee->active_committee_members->find(Auth::user()->id);

        $canManage = 0;
        if($user !== null &&
            $user->hasRole('committee') &&
            $user->hasPermissionTo('manage committee') &&
            in_array($user->pivot->role, $committee_executive_roles)
            ||
            Auth::user()->hasRole('super-admin')) {
                $canManage = 1;
        }

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
                'canManage' => $canManage,
                'action' => 'View',
            ]
        ]);
    }

    /**
     * @param Committee $any_committee
     * @return Factory|View
     */
    public function edit(Committee $any_committee)
    {
        $any_committee->load('creator','posts');

        $this->authorize('update', $any_committee);

        return view('admin.committee', [
            'data' => [
                'committee' => $any_committee,
                'access_levels' => Options::access_levels(),
                'action' => 'Edit',
            ],
        ]);
    }

    /**
     * @param UpdateCommitteeRequest $request
     * @param Committee $any_committee
     * @return RedirectResponse
     */
    public function update(UpdateCommitteeRequest $request, Committee $any_committee): RedirectResponse
    {
        $this->authorize('update', $any_committee);

        $any_committee->fill($request->committee);
        $any_committee->save();

        Session::flash('success', "You have updated " . $any_committee->name);

        return redirect()->route('committee_edit', $any_committee->slug);
    }

    /**
     * @param DestroyCommitteeRequest $request
     * @return RedirectResponse
     */
    public function destroy(DestroyCommitteeRequest $request): RedirectResponse
    {
        $this->authorize('delete', Committee::class);

        Committee::withoutGlobalScopes()
            ->find($request->id)
            ->each(function (Committee $committee) {

                $committee->committee_members()->detach();

                //todo committee set to... archive?
                //todo committee destroy committee relation?
                //todo committee destroy committee posts?

                $committee->delete();
            });

        Session::flash('success', Str::plural('Committee', count($request->id)) . ' deleted.');

        return redirect()->route('committees_list');
    }
}
