<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class HireUsController extends Controller
{
    /**
     * @return View
     */
    public function show(): View
    {
        $data = [];

        return view('hire-us', ['data' => $data]);
    }
}
