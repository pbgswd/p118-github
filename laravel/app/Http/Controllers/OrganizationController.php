<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use Illuminate\Support\Facades\Auth;

class OrganizationController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function list()
    {
        $data = [];
        $data['organizations'] = Organization::sortable()->orderBy('name')->paginate(10);

        return view('organizations', ['data' => ['data' => $data]]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Organization  $organization
     * @return \Illuminate\Http\Response
     */
    public function show(Organization $organization)
    {

        $organization->load('agreements');
        $data = [];
        $data['organization'] = $organization;

        return view('organization', ['data' => $data]);
    }
}
