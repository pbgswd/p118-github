<?php

namespace App\Http\Controllers;

use App\Models\Contactlist;
use App\Models\Contactlistdata;
use Illuminate\Http\Request;
//  \App\Models\Contactlist::factory()->make();
class ContactlistController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $contactlist = Contactlist::all();
        $contactlistdata = Contactlistdata::all();
        $data = [
            'contactlist' => $contactlist,
            'contactlistdata' => $contactlistdata,
            ];

       // dd($contactlist);

        return view('employer-list', ['data' => $data]);

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
