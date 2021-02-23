<?php

namespace App\Http\Controllers;

use App\Models\Agreement;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AgreementController extends Controller
{
    /**
     * @return View
     */
    public function list(): View
    {
        //todo member/public for attachments
        $data = [];

        if (Auth::check() == false) {
            $data['agreements'] = Agreement::where([['live', 1],['access_level', 'public']])
                ->with('attachments')
                ->orderBy('until', 'desc')
                ->sortable()
                ->paginate(10);

            $data['count'] = Agreement::where([['live', 1],['access_level', 'public']])->count();
        } else {

            $data['agreements'] = Agreement::where('live', 1)
                ->sortable()
                ->with('attachments')
                ->orderBy('until', 'desc')
                ->paginate(10);

            $data['count'] = Agreement::where('live', 1)->count();
        }

        return view('agreements_list', ['data' => ['data' => $data]]);
    }

    /**
     * @param Agreement $agreement
     * @return View
     */
    public function show(Agreement $agreement): View
    {
        $agreement->load('user', 'attachments');

        return view('agreement_view', ['data' => ['agreement' => $agreement]]);
    }
}
