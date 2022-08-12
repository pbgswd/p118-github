<?php

namespace App\Http\Controllers;

use App\Http\Requests\Executive\DestroyAdminExecutiveMembership;
use App\Http\Requests\Executive\StoreAdminExecutiveMembership;
use App\Http\Requests\Executive\UpdateAdminExecutiveMembership;
use App\Models\Executive;
use App\Models\ExecutiveMembership;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

class AdminExecutiveMembershipController extends Controller
{
    /**
     * @return View
     * @throws AuthorizationException
     */
    public function index(): View
    {
        $this->authorize('viewAny', ExecutiveMembership::class);
        //todo index method
        //'admin_executives_list'
        $data = [];

        /***
               $data = [];
               $data['executives'] = Executive::sortable()
         * ->with('user')->orderBy('created_at', 'desc')->paginate(20);
               $data['count'] = Executive::count();
**/

        return view('admin.executives_list', ['data' => $data]);
    }

    /**
     * @param User $user
     * @return View
     * @throws AuthorizationException
     */
    public function create(User $user): View
    {
        $this->authorize('create', ExecutiveMembership::class);

        $data = [
            'user' => $user,
            'assigned_role' => [],
            'roles' => Executive::all(),
            'action' => 'Create',
        ];

        return view('admin.executive', ['data' => $data]);
    }

    /**
     * @param StoreAdminExecutiveMembership $request
     * @param User $user
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function store(StoreAdminExecutiveMembership $request, User $user): RedirectResponse
    {
        $this->authorize('create', ExecutiveMembership::class);

        $executiveMembership = new ExecutiveMembership($request->input('executive'));
        $executiveMembership->user_id = $user->id;
        $endDate = Carbon::createFromDate($request->end_date);
        $executiveMembership->current = $endDate->isPast() ? 0 : 1;
        $executiveMembership->save();

        //todo msg member that he she has a role.

        Session::flash('success', 'You have created a member executive role');

        return redirect()->route('admin_executive_edit', $executiveMembership->id);
    }

    /**
     * @param ExecutiveMembership $executiveMembership
     * @return View
     * @throws AuthorizationException
     */
    public function edit(ExecutiveMembership $executiveMembership): View
    {
        $this->authorize('update', ExecutiveMembership::class);

        $executiveMembership->load('user');

        $data = [
            'user' => $executiveMembership->user,
            'assigned_role' => $executiveMembership,
            'roles' => Executive::all(),
            'action' => 'Edit',
        ];

        return view('admin.executive', [$executiveMembership->id], ['data' => $data]);
    }

    /**
     * @param UpdateAdminExecutiveMembership $request
     * @param ExecutiveMembership $executiveMembership
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function update(UpdateAdminExecutiveMembership $request,
                           ExecutiveMembership $executiveMembership): RedirectResponse
    {
        $this->authorize('update', ExecutiveMembership::class);

        $executiveMembership->fill($request->input('executive'));
        $executiveMembership->save();

        Session::flash('success', 'Role has been updated');

        return redirect()->route('admin_executive_edit', $executiveMembership->id);
    }

    /**
     * @param DestroyAdminExecutiveMembership $request
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function destroy(DestroyAdminExecutiveMembership $request): RedirectResponse
    {
        $this->authorize('delete', ExecutiveMembership::class);

        foreach ($request->ids as $i) {
            $e = ExecutiveMembership::find($i);
            $e->delete();
        }

        Session::flash('success', 'Executive role deleted.');

        return redirect()->route('admin_executives');
    }
}
