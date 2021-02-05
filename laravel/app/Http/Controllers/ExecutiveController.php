<?php

namespace App\Http\Controllers;

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
        $data = Executive::with('current_executive_user')->get();

        return view('executive_list', ['data' => $data]);
    }
}
