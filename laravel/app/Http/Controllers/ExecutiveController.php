<?php

namespace App\Http\Controllers;

use App\Models\Executive;
use Illuminate\Http\Response;

class ExecutiveController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $data = [];
        $data = Executive::with('current_executive_user')->get();

        return view('executive_list', ['data' => $data]);
    }

}
