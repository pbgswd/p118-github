<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Committees\DestroyCommitteeRequest;
use App\Http\Requests\Committees\StoreCommitteeRequest;
use App\Http\Requests\Committees\UpdateCommitteeRequest;
use App\Models\Committee;
use App\Models\Options;
use App\Models\User;
use App\Services\AttachmentService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class AdminCommitteeController extends Controller
{
    /**
     * @throws AuthorizationException
     */
    public function index(): View
    {
        $this->authorize('viewAny', Committee::class);
        $c = Committee::withoutGlobalScopes()->with('creator')->sortable()->paginate(10);

        $m = null;
        $user = Auth::user();
        if ($user->hasPermissionTo('manage committee')
        ) {
            $m = $user->committee_memberships;
        }

        $count = Committee::all()->count();

        return view('admin.listcommittees', ['data' => ['committees' => $c, 'count' => $count, 'manage committees' => $m]]);
    }

    /**
     * @throws AuthorizationException
     */
    public function create(): View
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
     * @throws AuthorizationException
     */
    public function store(StoreCommitteeRequest $request): RedirectResponse
    {
        $this->authorize('create', Committee::class);

        $committee = new Committee($request->input('committee'));
        $committee->user_id = Auth::id();

        if (! is_null($request->file('committee.image'))) {
            $committee['image'] = $this->uploadImage($request);
            $committee['file_name'] = $request->file('committee.image')->getClientOriginalName();
        }

        $committee->save();

        Session::flash('success', 'You have created a new committee, '.$committee->name);

        return redirect()->route('admin_committee_show', $committee->slug);
    }

    /**
     * @throws AuthorizationException
     */
    public function show(Committee $committee): View
    {
        $this->authorize('view', $committee);

        $committee->load('creator', 'active_committee_members', 'posts');
        $committee['committee_roles'] = Options::committee_roles();
        $committee_executive_roles = Options::committee_executive_roles();

        $user = $committee->active_committee_members->find(Auth::user()->id);

        $canManage = 0;

        if ($user !== null &&
            $user->hasRole('committee') &&
            $user->hasPermissionTo('manage committee') &&
            in_array($user->pivot->role, $committee_executive_roles) ||
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

        $data = [
            'committee' => $committee,
            'canManage' => $canManage,
        ];

        return view('admin.show_committee', ['data' => $data]);
    }

    /**
     * @throws AuthorizationException
     */
    public function edit(Committee $any_committee): View
    {
        $any_committee->load('creator', 'posts');

        $this->authorize('update', $any_committee);

        $file_info = null;

        if ($any_committee['image'] !== null) {
            $file_info['file_size'] = AttachmentService::human_filesize(\filesize(\storage_path('app/committees'.
                '/'.$any_committee['image'])));

            $file_info['dimensions'] = \getimagesize(\storage_path('app/committees').'/'.
                $any_committee['image']);
        }

        return view('admin.committee', [
            'data' => [
                'committee' => $any_committee,
                'file_info' => $file_info,
                'access_levels' => Options::access_levels(),
                'action' => 'Edit',
            ],
        ]);
    }

    /**
     * @throws AuthorizationException
     */
    public function update(UpdateCommitteeRequest $request, Committee $any_committee): RedirectResponse
    {
        $this->authorize('update', $any_committee);

        $any_committee->fill($request->committee);

        if (isset($request->committee['delete_image'])) {
            Storage::disk('committees')->delete($any_committee['image']);

            Session::flash('info', 'You have deleted '.$any_committee['image']);
            $any_committee['image'] = null;
            $any_committee['file_name'] = null;
        } else {
            if (! is_null($request->file('committee.image'))) {
                $any_committee['image'] = $this->uploadImage($request);
                $any_committee['file_name'] = $request->file('committee.image')->getClientOriginalName();
            }
        }

        $any_committee->save();

        Session::flash('success', 'You have updated '.$any_committee->name);

        return redirect()->route('committee_edit', $any_committee->slug);
    }

    /**
     * @throws AuthorizationException
     */
    public function destroy(DestroyCommitteeRequest $request): RedirectResponse
    {
        $this->authorize('delete', Committee::class);

        Committee::withoutGlobalScopes()
            ->find($request->id)
            ->each(function (Committee $committee) {

                //dump($committee);
                //dump(Auth::user()->with('membership'));
                //todo a plan to deal with orphaned committee posts other than deletion
                $committee->posts()->delete();
                // does user have the role
                // what is the committee
                // what is the user
                // does the user have privileges

                $committee->committee_members()->detach();

                if ($committee['image']) {
                    Storage::disk('committees')->delete($committee['image']);
                }
                //todo committee set to... archive?
                //todo committee destroy committee relation?
                //todo committee destroy committee posts?

                $committee->delete();
            });

        Session::flash('success', Str::plural('Committee', count([$request->id])).' deleted.');

        return redirect()->route('committees_list');
    }

    protected function uploadImage(FormRequest $request): string
    {
        return $request->file('committee.image')->store('', 'committees');
    }
}
