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
     * @return View
     */
    public function index(): View
    {
        //Land on the home page of admin. Could have data later.
        $data = [['user' => Auth::user()]];

        return view('admin.admin', ['data' => $data]);
    }

    /**
     * @return View
     */
    public function developer(): View
    {
        return view('admin.developer_admin');
    }

    /**
     * @param User $user
     * @return View
     */
    public function blank(User $user): View
    {
        return view('admin.admin-blank');
    }
}
