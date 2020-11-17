<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Response;
use Illuminate\View\View;

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
     * @return Application|Factory|View
     */
    public function blank(User $user)
    {

        return view('admin.admin-blank');
    }

}
