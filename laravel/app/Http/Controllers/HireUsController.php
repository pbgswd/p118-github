<?php

namespace App\Http\Controllers;

class HireUsController extends Controller
{
    public function show()
    {
        $data = [];
        return view('hire-us', ['data' => $data]);
    }

}
