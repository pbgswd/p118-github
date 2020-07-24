<?php

namespace App\Http\Controllers;

use App\Models\Executive;
use Illuminate\Http\Request;

class ExecutiveController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [];
        $data = Executive::with('user')->get();

        return view('executive_list', ['data' => $data]);
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Executive  $executive
     * @return \Illuminate\Http\Response
     */
    public function show(Executive $executive)
    {
        //
    }


}
