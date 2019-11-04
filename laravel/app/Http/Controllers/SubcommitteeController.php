<?php

namespace App\Http\Controllers;

use App\Http\Requests\Subcommittee\StoreSubcommittee;
use App\Http\Requests\Subcommittee\UpdateSubcommittee;
use App\Models\Subcommittee;

class SubcommitteeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSubcommittee $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Subcommittee  $subcommittee
     * @return \Illuminate\Http\Response
     */
    public function show(Subcommittee $subcommittee)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Subcommittee  $subcommittee
     * @return \Illuminate\Http\Response
     */
    public function edit(Subcommittee $subcommittee)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Subcommittee  $subcommittee
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSubcommittee $request, Subcommittee $subcommittee)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Subcommittee  $subcommittee
     * @return \Illuminate\Http\Response
     */
    public function destroy(DestroySubcommittee $subcommittee)
    {
        //
    }
}
