<?php

namespace App\Http\Controllers\Admin;

use App\Constants\AccessLevelConstants;
use App\Http\Controllers\Controller;
use App\Models\Contactlist;
use App\Models\Contactlistdata;
use Illuminate\Http\Request;

class AdminContactlistdataController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        dd(Contactlistdata::all());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $cldata = new Contactlistdata;

        $data = [
            'action' => 'Create',
            'cldata' => $cldata,
            'access_levels' => array_combine(AccessLevelConstants::getConstants(), AccessLevelConstants::getConstants()),
            'model_name' => 'contactlistdata',
        ];

        return view('admin.contactlistdata_edit', ['data' => $data]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Contactlistdata $contactlistdata)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Contactlistdata $contactlistdata)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Contactlistdata $contactlistdata)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Contactlistdata $contactlistdata)
    {
        //
    }
}
