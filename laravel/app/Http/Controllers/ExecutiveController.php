<?php

namespace App\Http\Controllers;

use App\Models\Executive;

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
        $data = Executive::with('current_executive_user')->get();

        return view('executive_list', ['data' => $data]);
    }

}
