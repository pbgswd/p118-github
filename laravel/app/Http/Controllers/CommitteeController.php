<?php

namespace App\Http\Controllers;

use App\Models\Committee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class CommitteeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $c = Committee::with('creator')->sortable()->paginate(10);
        return view('committees', ['data'=>array('committees'=>$c)]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Committee $committee)
    {
        $committee->committee_members()->attach(Auth::id(), ['role' => 'Member']);

        Session::flash('success', 'You have joined '. $committee->name);

        return redirect()->route('committee', $committee->slug);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Committee  $committee
     * @return \Illuminate\Http\Response
     */
    public function show(Committee $committee)
    {
        $committee->creator;

        return view('committee', ['data' => ['committee' => $committee]]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Committee  $committee
     * @return \Illuminate\Http\Response
     */
    public function edit(Committee $committee)
    {
        // allow chair, cochair, and secretary to edit
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Committee  $committee
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Committee $committee)
    {
        //// allow chair, cochair, and secretary to update
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Committee  $committee
     * @return \Illuminate\Http\Response
     */
    public function destroy(Committee $committee)
    {
        //     //// allow chair, cochair, and secretary to destroy? Or set to archive.
    }
}
