<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
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
