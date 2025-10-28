<?php

namespace App\Http\Controllers\Admin;

use App\Constants\AccessLevelConstants;
use App\Http\Controllers\Controller;
use App\Models\Contactlist;
use Illuminate\Http\Request;

class AdminContactlistController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $contactList = Contactlist::all();
        $data = [
            'contactlist' => $contactList[0],
            'action' => 'list',
            'access_levels' => array_combine(AccessLevelConstants::getConstants(), AccessLevelConstants::getConstants()),
            'model_name' => 'Contactlist',
        ];
        //dd($data);

        return view('admin.contactlist', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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
    public function show(Contactlist $contactlist)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Contactlist $contactlist)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Contactlist $contactlist)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Contactlist $contactlist)
    {
        //
    }
}
