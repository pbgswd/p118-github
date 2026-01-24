<?php

namespace App\Http\Controllers;

use App\Models\Committee;
use App\Models\Executive;
use Illuminate\View\View;

class ExecutiveController extends Controller
{
    public function index(): View
    {
        /**
         * H&W id = 7
         * Trustee id = 10
         */
        $executive = Executive::whereIn('id', [1,2,3,4,5,6])->with('current_executive_user')->get();
        $trustees = Executive::where('id', 10)->with('current_executive_user')->get();
        $health = Executive::where('id', 7)->with('current_executive_user')->get();
        $health_trustees = Executive::where('title','Health & Welfare Trustee')->with('current_executive_user')->get();
        $committees = Committee::where('live', 1)->get();

        $data = [
            'health' => $health,
            'executive' => $executive,
            'committees' => $committees,
            'trustees' => $trustees,
            'health_trustees' => $health_trustees,
            'title' => 'Executive, Administrators, and Trustees',
        ];

        return view('executive_list', ['data' => $data]);
    }
}
