<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;


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
     * @return Application|RedirectResponse|Redirector
     *
     */
    public function index()
    {
        //todo anything for the front page.
        return redirect('/'); //view('home');
    }
}
