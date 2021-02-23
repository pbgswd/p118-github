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
        /**
         * H&W id = 7
         * Trustee id = 10
         */
        $executive = Executive::whereNotIn('id', [7, 10])->with('current_executive_user')->get();
        $trustees = Executive::where('id', 10)->with('current_executive_user')->get();
        $health = Executive::where('id', 7)->with('current_executive_user')->get();
        $committees = Committee::where('live', 1)->get();

        $data = [
            'health' => $health,
            'executive' => $executive,
            'committees' => $committees,
            'trustees' => $trustees,
        ];

        return view('executive_list', ['data' => $data]);
    }
}
