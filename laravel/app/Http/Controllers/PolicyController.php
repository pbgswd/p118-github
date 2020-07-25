<?php

namespace App\Http\Controllers;

use App\Models\Policy;

class PolicyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$this->authorize('viewAny', Auth::user());
        $data = [];
        $data['policies'] = Policy::sortable()->with('attachments')->orderBy('date', 'desc')->paginate(20);
        $data['count'] = Policy::count();

        return view('policies_list', ['data' => ['data' => $data]]);
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Policy  $policy
     * @return \Illuminate\Http\Response
     */
    public function show(Policy $policy)
    {
        $policy->load('user', 'attachments');

        return view('policy_view', ['data' => ['policy' => $policy]]);
    }

}
