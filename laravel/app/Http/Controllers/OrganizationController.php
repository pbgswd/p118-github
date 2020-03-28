<?php

namespace App\Http\Controllers;

use App\Http\Requests\Organization\DestroyOrganizationRequest;
use App\Http\Requests\Organization\StoreOrganizationRequest;
use App\Http\Requests\Organization\UpdateOrganizationRequest;
use App\Models\Organization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class OrganizationController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index()
    {
        $this->authorize('viewAny', Auth::user());
        $data = [];
        $data['organizations'] = Organization::sortable()->orderBy('name')->paginate(10);

        return view('admin.listorganizations', ['data' => ['data' => $data]]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Organization  $organization
     * @return \Illuminate\Http\Response
     */
    public function show(Organization $organization)
    {
        dd(__METHOD__);
    }
}
