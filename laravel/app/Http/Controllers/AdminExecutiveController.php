<?php

namespace App\Http\Controllers;

use App\Http\Requests\Executive\DestroyAdminExecutive;
use App\Http\Requests\Executive\StoreAdminExecutive;
use App\Http\Requests\Executive\UpdateAdminExecutive;
use App\Models\Executive;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

class AdminExecutiveController extends Controller
{
    /**
     * @return View
     * @throws AuthorizationException
     */
    public function index(): View
    {
        $this->authorize('viewAny', Executive::class);


        /***
               $data = [];
               $data['executives'] = Executive::sortable()
         * ->with('user')->orderBy('created_at', 'desc')->paginate(20);
               $data['count'] = Executive::count();
**/

        $data = Executive::with('user')->get();
//dd($data);
        return view('admin.executives_list', ['data' => $data]);
    }

    /**
     * @param User $user
     * @return View
     * @throws AuthorizationException
     */
    public function create(User $user): View
    {
        $this->authorize('create', Executive::class);

        $data = [
            'user' => $user,
            'assigned_role' => [],
            'roles' => Executive::all(),
            'action' => 'Create',
        ];

        return view('admin.executive', ['data' => $data]);
    }

    /**
     * @param StoreAdminExecutive $request
     * @param User $user
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function store(StoreAdminExecutive $request, User $user): RedirectResponse
    {
        $this->authorize('create', Executive::class);

        $executive = new Executive($request->input('executive'));
        $executive->user_id = $user->id;
        $endDate = Carbon::createFromDate($request->end_date);
        $executive->current = $endDate->isPast() ? 0 : 1;
        $executive->save();

        //todo msg member that he she has a role.

        Session::flash('success', 'You have created a member executive role');

        return redirect()->route('admin_executive_edit', $executive->id);
    }

    /**
     * @param Executive $executive
     * @return View
     * @throws AuthorizationException
     */
    public function edit(Executive $executive): View
    {
        $this->authorize('update', Executive::class);

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
     * @param UpdateAdminExecutive $request
     * @param Executive $executive
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function update(UpdateAdminExecutive $request,
                           Executive $executive): RedirectResponse
    {
        $this->authorize('update', Executive::class);

        $executive->fill($request->input('executive'));
        $executive->save();

        Session::flash('success', 'Role has been updated');

        return redirect()->route('admin_executive_edit', $executive->id);
    }

    /**
     * @param DestroyAdminExecutive $request
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function destroy(DestroyAdminExecutive $request): RedirectResponse
    {
        $this->authorize('delete', Executive::class);

/*        foreach ($request->id as $i) {
            $e = Executive::find($i);
            $e->delete();
        }*/

        Executive::find($request->id)
            ->each(function(Executive $executive) {
                $executive->delete();
            });

        Session::flash('success', 'Executive role deleted.');

        return redirect()->route('admin_executives_list');
    }
}
