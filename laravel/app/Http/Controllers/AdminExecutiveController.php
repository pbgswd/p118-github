<?php

namespace App\Http\Controllers;

use App\Models\Executive;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Response;
use Illuminate\View\View;

class AdminExecutiveController extends Controller
{
    /**
     * @return View
     * @throws AuthorizationException
     */
    public function index(): View
    {
        $this->authorize('viewAny', Executive::class);

        $data = [];
        $data['executives'] = Executive::with('user')->get();

        return view('admin.executives_list', ['data' => $data]);
    }
}
