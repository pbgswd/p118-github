<?php

namespace App\Http\Controllers;

use App\Models\Site;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

class SiteController extends Controller
{
    /**
     * @return View
     */
    public function index(): View
    {
        $user = Auth::user()->load('phone_number', 'user_info');

        return view('site', ['data' => ['user' => $user]]);
    }
}
