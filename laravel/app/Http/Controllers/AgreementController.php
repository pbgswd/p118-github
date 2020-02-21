<?php

namespace App\Http\Controllers;

use App\Http\Requests\Agreements\DestroyAgreement;
use App\Http\Requests\Agreements\StoreAgreement;
use App\Http\Requests\Agreements\UpdateAgreement;
use App\Models\Agreement;
use App\Models\Organization;
use App\Models\Venue;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AgreementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $this->authorize('viewAny', Auth::user());

        $data = [];
        $data['agreements'] = [];

        return view('admin.agreements_list', ['data' => ['data' => $data]]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $this->authorize('create', Auth::user());
        $data = [];
        $data['agreement'] = new Agreement;
        $access_levels = $this->getFormOptions(['access_levels']);
        $data['venues'] = Venue::all();
        $data['organizations'] = Organization::all();

        return view('admin.agreement', ['data' => ['data' => $data, 'access_levels' => $access_levels, 'action' => 'Create']]);
    }

    /**
     * @param StoreAgreement $request
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(StoreAgreement $request)
    {
        $this->authorize('create', Auth::user());
        dd(__METHOD__); //
    }

    /**
     * Display the specified resource.
     *
     * @param Agreement $agreement
     * @return Response
     */
    public function show(Agreement $agreement)
    {
        dd(__METHOD__);//
    }

    /**
     * @param UpdateAgreement $agreement
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(UpdateAgreement $agreement)
    {
        $this->authorize('update', Auth::user());
        $data['venues'] = Venue::all();
        $data['organizations'] = Organization::all();
        dd(__METHOD__); //
    }

    /**
     * @param Request $request
     * @param UpdateAgreement $agreement
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(Request $request, UpdateAgreement $agreement)
    {
        $this->authorize('update', Auth::user());
        dd(__METHOD__);  //
    }

    /**
     * @param DestroyAgreement $agreement
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(DestroyAgreement $agreement)
    {
        $this->authorize('delete', Auth::user());
        dd(__METHOD__); //
    }
}
