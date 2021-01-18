<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
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
        $data = [['user' => Auth::user()]];

        return view('admin.admin', ['data' => $data]);
    }

    public function developer()
    {
        return view('admin.developer_admin');
    }

    /**
     * @return Application|Factory|View
     */
    public function blank(User $user)
    {
        return view('admin.admin-blank');
    }
}
