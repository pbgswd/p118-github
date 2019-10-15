<?php

namespace App\Http\Controllers;

use App\Http\Requests\Venues\UpdateVenue;
use Auth;
use App\Models\Venue;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use App\Http\Requests\Venues\StoreVenue;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;


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
    public function store(StoreVenue $request)
    {
       //todo migration to handle default user value in db table

        $venue = new Venue($request->input('venue'));

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
        return view('admin.venue', ['data' => ['venue' => $venue, 'action' => 'Edit']]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Venue  $venue
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateVenue $request, Venue $venue)
    {
        $data = $request['venue'];
        $data['image'] = $this->uploadImage($request);
        if (isset( $request['venue']['delete_image']))
        {
            Storage::disk('public')->delete( $request->venue['image'] );
            Session::flash('info', "You have deleted " . $data['image']);
            $data['image'] = NULL;
        }
        $venue->fill($data);
        $venue->save();
        Session::flash('success', "You have edited the venue");

        return redirect()->route('venue_edit', [$venue->slug]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Venue  $venue
     * @return \Illuminate\Http\Response
     */
    public function destroy(DestroyVenue $venue)
    {
        //
        echo __METHOD__; exit();
    }

    protected function uploadImage(FormRequest $request)
    {
        if (!$request->image) {
            return null;
        }

        $imageName = $request->image->getClientOriginalName();

        if (!$request->image->storeAs('public', $imageName)) {
            Session::flash('warning', "Did not store " . $imageName);

            return null;
        }

        return $imageName;
    }
}
