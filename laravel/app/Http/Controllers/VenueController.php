<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\Venue;
use Illuminate\Http\Request;
use App\Http\Requests\Venues\StoreVenue;


class VenueController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [];
        $data['venues'] = Venue::sortable()->paginate(20);


        return view('admin.listvenues', ['data'=>array('data'=>$data)]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function list()
    {
        echo __METHOD__; exit();
        //public  list
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $venue = new Venue;
        $venue['user_id'] = Auth::id();

        return view('admin.venue', ['data' => ['venue' => $venue, 'action' => 'Create']]);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $venue = new Venue($request->input('venue');

        $venue->image = $this->uploadImage($request);

        $venue->save();

        Session::flash('success', "You have saved a new venue");

        return redirect()->route('venue_edit', [$venue->slug]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Venue  $venue
     * @return \Illuminate\Http\Response
     */
    public function show(Venue $venue)
    {
        echo __METHOD__; exit();
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Venue  $venue
     * @return \Illuminate\Http\Response
     */
    public function edit(Venue $venue)
    {
        //
        echo __METHOD__; exit();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Venue  $venue
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Venue $venue)
    {
        //
        echo __METHOD__; exit();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Venue  $venue
     * @return \Illuminate\Http\Response
     */
    public function destroy(Venue $venue)
    {
        //
        echo __METHOD__; exit();
    }
}
