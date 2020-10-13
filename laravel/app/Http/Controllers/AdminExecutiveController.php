<?php

namespace App\Http\Controllers;


use App\Models\Executive;
use Illuminate\Http\Response;

class AdminExecutiveController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $data = [];
        $data['executives'] = Executive::with('user')->get();

        return view('admin.executives_list', ['data' => $data]);
    }

}
