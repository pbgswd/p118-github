<?php

namespace App\Http\Controllers;

use App\Http\Requests\Agreements\DestroyAgreement;
use App\Http\Requests\Agreements\StoreAgreement;
use App\Http\Requests\Agreements\UpdateAgreement;
use App\Models\Agreement;
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
        $data = [];
        $data['agreement'] = new Agreement;
        $access_levels = $this->getFormOptions(['access_levels']);
        $data['venues'] = Venue::all();

        return view('admin.agreement', ['data' => ['data' => $data, 'access_levels' => $access_levels, 'action' => 'Create']]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(StoreAgreement $request)
    {
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
     * Show the form for editing the specified resource.
     *
     * @param Agreement $agreement
     * @return Response
     */
    public function edit(UpdateAgreement $agreement)
    {
        dd(__METHOD__); //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Agreement $agreement
     * @return Response
     */
    public function update(Request $request, UpdateAgreement $agreement)
    {
        dd(__METHOD__);  //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Agreement $agreement
     * @return Response
     */
    public function destroy(DestroyAgreement $agreement)
    {
        dd(__METHOD__); //
    }
}
