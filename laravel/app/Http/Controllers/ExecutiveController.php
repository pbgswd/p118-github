<?php

namespace App\Http\Controllers;

use App\Models\Committee;
use App\Models\Executive;
use Illuminate\View\View;

class ExecutiveController extends Controller
{
    /**
     * @return View
     */
    public function index(): View
    {
        $data = [];
       // dd(Committee::all());

        $data = [
            'executive' => Executive::with('current_executive_user')->get(),
            'committees' => Committee::all(),
            'trustees' => [],
        ];

        return view('executive_list', ['data' => $data]);
    }
}
