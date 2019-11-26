<?php

namespace App\Http\Controllers;

use App\Http\Requests\Venues\DestroyVenue;
use App\Http\Requests\Venues\StoreVenue;
use App\Http\Requests\Venues\UpdateVenue;
use App\Models\Venue;
use Auth;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


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
        $data['venues'] = Venue::sortable()->orderBy('name')->paginate(10);

        return view('admin.listvenues', ['data'=>array('data'=>$data)]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function list()
    {
        $data = [];
        $data['venues'] = Venue::paginate(20);

        return view('venues', ['data'=>array('data'=>$data)]);
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
        return view('venue', ['data' => ['venue' => $venue]]);
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
    public function destroy(DestroyVenue $request)
    {
        $venues = Venue::find($request->id);
        foreach($venues as $v)
        {
            Venue::destroy($v->id);
        }
        Session::flash('success', Str::plural(count($request->id) .' Venue', count($request->id)) . ' deleted.');

        return redirect()->route('venues_list');
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
