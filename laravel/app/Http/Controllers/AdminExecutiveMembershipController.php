<?php

namespace App\Http\Controllers;

use App\Http\Requests\Executive\DestroyAdminExecutiveMembership;
use App\Http\Requests\Executive\StoreAdminExecutiveMembership;
use App\Http\Requests\Executive\UpdateAdminExecutiveMembership;
use App\Models\Executive;
use App\Models\ExecutiveMembership;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;


class AdminExecutiveMembershipController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
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
     * Show the form for creating a new resource.
     *
     * @param User $user
     * @return Response
     */
    public function create(User $user)
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
     * Store a newly created resource in storage.
     *
     * @param StoreAdminExecutiveMembership $request
     * @param User $user
     * @return Response
     */
    public function store(StoreAdminExecutiveMembership $request, User $user)
    {
        $this->authorize('create', ExecutiveMembership::class);

        $executiveMembership = new ExecutiveMembership($request->input('executive'));
        $executiveMembership->user_id = $user->id;
        $endDate = Carbon::createFromDate($request->end_date);
        $executiveMembership->current = $endDate->isPast() ? 0 : 1;
        $executiveMembership->save();

        //todo msg member that he she has a role.

        Session::flash('success', "You have created a member executive role");

        return redirect()->route('admin_executive_edit', $executiveMembership->id);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param ExecutiveMembership $executiveMembership
     * @return Response
     */
    public function edit(ExecutiveMembership $executiveMembership)
    {
        $this->authorize('update', ExecutiveMembership::class);

        $executiveMembership->load('user');

        $data = [
            'user' => $executiveMembership->user,
            'assigned_role' => $executiveMembership,
            'roles' => Executive::all(),
            'action' => 'Edit',
        ];

        return view('admin.executive', [$executiveMembership->id], ['data' => $data] );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateAdminExecutiveMembership $request
     * @param ExecutiveMembership $executiveMembership
     * @return Response
     */
    public function update(UpdateAdminExecutiveMembership $request, ExecutiveMembership $executiveMembership)
    {
        $this->authorize('update', ExecutiveMembership::class);

        $executiveMembership->fill($request->input('executive'));
        $executiveMembership->save();

        Session::flash('success', "Role has been updated");

        return redirect()->route('admin_executive_edit', $executiveMembership->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyAdminExecutiveMembership $request
     * @return Response
     */
    public function destroy(DestroyAdminExecutiveMembership $request)
    {
        $this->authorize('delete', ExecutiveMembership::class);

        foreach($request->id as $i)
        {
            $e = ExecutiveMembership::find($i);
            $e->delete();
        }

        Session::flash('success', 'Executive role deleted.');

        return redirect()->route('admin_executives');
    }
}
