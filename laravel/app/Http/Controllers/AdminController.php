<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //Land on the home page of admin. Could have data later.
        $data = [];
        return view('admin.admin', ['data' => $data]);
    }


    /**
     * Display the specified resource.
     *
     * @param \App\Admin $admin
     * @return Response
     */
    public function blank(Admin $admin)
    {
        // a page for doing css/js/html experiments
        return view('admin.admin-blank');
    }

}
