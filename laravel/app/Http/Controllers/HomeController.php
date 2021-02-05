<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;

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
     * @return RedirectResponse
     */
    public function index(): RedirectResponse
    {
        //todo anything for the front page.
        return redirect('/'); //view('home');
    }
}
