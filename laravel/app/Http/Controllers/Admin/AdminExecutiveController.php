<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Executive\DestroyAdminExecutive;
use App\Http\Requests\Executive\StoreAdminExecutive;
use App\Http\Requests\Executive\UpdateAdminExecutive;
use App\Models\Executive;
use App\Models\ExecutiveMembership;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

class AdminExecutiveController extends Controller
{
    /**
     * @throws AuthorizationException
     */
    public function index(): View
    {
        Gate::authorize('viewAny', Executive::class);
        /***
               $data = [];
               $data['executives'] = Executive::sortable()
         * ->with('user')->orderBy('created_at', 'desc')->paginate(20);
               $data['count'] = Executive::count();
        **/
        $data = Executive::with('user')->get();

        return view('admin.executives_list', ['data' => $data]);
    }

    /**
     * @throws AuthorizationException
     */
    public function create(User $user): View
    {
        Gate::authorize('create', Executive::class);

        $data = [
            'user' => $user,
            'assigned_role' => [],
            'roles' => Executive::all(),
            'action' => 'Create',
        ];

        return view('admin.executive', ['data' => $data]);
    }

    /**
     * @throws AuthorizationException
     */
    public function store(StoreAdminExecutive $request, Executive $executive, User $user): RedirectResponse
    {

        Gate::authorize('create', Executive::class);

        $executive = new ExecutiveMembership($request->input('executive'));
        $executive->user_id = $user->id;
        $executive->start_date = Carbon::createFromDate($request->executive['start_date']);
        $executive->end_date = Carbon::createFromDate($request->executive['end_date']);
        $executive->current = $executive->end_date->isPast() ? 0 : 1;

        $executive->save();

        // todo msg member that he she has a role.

        Session::flash('success', 'You have created a member executive role');

        return redirect()->route('admin_executive_edit', $executive->id);
    }

    /**
     * @throws AuthorizationException
     */
    public function edit(ExecutiveMembership $executive): View
    {

        Gate::authorize('update', Executive::class);

        $executive->load('user');

        $data = [
            'user' => $executive->user,
            'assigned_role' => $executive,
            'roles' => Executive::all(),
            'action' => 'Edit',
        ];

        return view('admin.executive', [$executive->id], ['data' => $data]);
    }

    /**
     * @throws AuthorizationException
     */
    public function update(UpdateAdminExecutive $request,
        ExecutiveMembership $executive): RedirectResponse
    {
        Gate::authorize('update', Executive::class);

        $executive->fill($request->input('executive'));
        $executive->save();

        Session::flash('success', 'Role has been updated');

        return redirect()->route('admin_executive_edit', $executive->id);
    }

    /**
     * @throws AuthorizationException
     */
    public function destroy(DestroyAdminExecutive $request): RedirectResponse
    {
        Gate::authorize('delete', Executive::class);

        ExecutiveMembership::find($request->id)
            ->each(function (ExecutiveMembership $executive) {
                $executive->delete();
            });

        Session::flash('success', 'Executive role deleted.');

        return redirect()->route('admin_executives_list');
    }
}
