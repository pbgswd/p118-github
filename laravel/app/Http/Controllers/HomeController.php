<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;


class HomeController extends Controller
{
    //todo does the site need HomeController any more?
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return Renderable
     */
    public function index()
    {
        return view('home');
    }
}
