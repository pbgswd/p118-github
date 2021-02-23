<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class HelloController extends Controller
{
    /**
     * @return View
     */
    public function index(): View
    {
        return view('hello');
    }
}
