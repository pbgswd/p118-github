<?php

namespace App\Http\Controllers;

use App\Models\Executive;
use App\Models\ExecutiveMembership;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;


class AdminExecutiveMembershipController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //todo index method
        //'admin_executives_list'
 /***
        $this->authorize('viewAny', Auth::user());
        $data = [];
        $data['executives'] = Executive::sortable()->with('user')->orderBy('created_at', 'desc')->paginate(20);
        $data['count'] = Executive::count();
**/
        return view('admin.executives_list', ['data' => $data]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(User $user)
    {

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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, User $user)
    {
        $executiveMembership = new ExecutiveMembership($request->input());
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
     * @param  \App\Models\ExecutiveMembership  $executiveMembership
     * @return \Illuminate\Http\Response
     */
    public function edit(ExecutiveMembership $executiveMembership)
    {
        $this->authorize('update', Auth::user());

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
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ExecutiveMembership  $executiveMembership
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ExecutiveMembership $executiveMembership)
    {
        //todo form request
        $executiveMembership->fill($request->all());
        $executiveMembership->save();

        Session::flash('success', "Role has been updated");

        return redirect()->route('admin_executive_edit', $executiveMembership->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ExecutiveMembership  $executiveMembership
     * @return \Illuminate\Http\Response
     */
    public function destroy(ExecutiveMembership $executiveMembership)
    {
        $user = $executiveMembership->user;

        ExecutiveMembership::destroy($executiveMembership->id);


        Session::flash('success', 'Executive role deleted.');

        return redirect()->route('user_edit', [$user->id]);
    }
}
