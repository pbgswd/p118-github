<?php

namespace App\Http\Controllers;

use App\Http\Requests\Executive\AdminDestroyExecutive;
use App\Models\Executive;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class AdminExecutiveController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //todo data washer to force any roles with end_date < now to set current=0

        $this->authorize('viewAny', Auth::user());
        $data = [];
        $data['executives'] = Executive::sortable()->with('user')->orderBy('created_at', 'desc')->paginate(20);
        $data['count'] = Executive::count();

        return view('admin.executives_list', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(User $user)
    {
        $this->authorize('create', Auth::user());

        $executive = new Executive;
//todo verify this is the right way to assign relation.
        $executive->user = $user;

        $data = [
            'executive' => $executive,
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
//todo form validator
        //todo status of current var
        $executive = new Executive($request->executive);
        $executive->user_id = $user->id;
        $executive->save();

        Session::flash('success', "Executive role for " . $user->name . " saved");

        return redirect()->route('admin_executive_edit', [$executive->id]);

    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Executive  $executive
     * @return \Illuminate\Http\Response
     */
    public function edit(Executive $executive)
    {
        $executive->load('user');
        //todo check end_date to set current
        $data = [
            'executive' => $executive,
            'action' => 'Edit',
        ];

        return view('admin.executive', ['data' => $data]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Executive  $executive
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Executive $executive)
    {
        //todo form validator
        //todo check end_date to set current

        $executive->fill($request->executive);
        $executive->save();
        $executive->user;

        Session::flash('success', "Executive role for " . $executive->user->name . " updated");

        return redirect()->route('admin_executive_edit', [$executive->user_id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Executive  $executive
     * @return \Illuminate\Http\Response
     */
    public function destroy(AdminDestroyExecutive $request)
    {
//todo why so null
       // dd($request->all());

        $executives = Executive::find($request->id)
            ->each(function(Executive $executive) {
                $executive->delete();
            });

        Session::flash('success', Str::plural($executives->count() . ' Executive role', $executives->count()) . ' deleted.');

        return redirect()->route('admin_executives_list');

    }
}
