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

        $executive = Executive::where('title', '!=', 'Trustee')->with('current_executive_user')->get();
        $trustees = Executive::where('title', '=', 'Trustee')->with('current_executive_user')->get();
        $committees = Committee::where('live', 1)->get();

        $data = [
            'executive' => $executive,
            'committees' => $committees,
            'trustees' => $trustees,
        ];

        return view('executive_list', ['data' => $data]);
    }
}
