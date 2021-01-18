<?php

namespace App\Http\Controllers;

use App\Models\Agreement;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AgreementController extends Controller
{
    /**
     * @return Factory|View
     */
    public function list()
    {
        //todo member/public for attachments
        $data = [];

        if (Auth::check() == false) {
            $data['agreements'] = Agreement::sortable()
                ->with('attachments')
                ->whereRaw('NOW() < until')
                ->orderBy('until', 'desc')
                ->paginate(20);

            $data['count'] = Agreement::with('attachments')
                ->whereRaw('NOW() < until')->count();
        } else {
            $data['agreements'] = Agreement::sortable()
                ->with('attachments')
                ->orderBy('until', 'desc')
                ->paginate(20);

            $data['count'] = Agreement::with('attachments')->count();
        }

        return view('agreements_list', ['data' => ['data' => $data]]);
    }

    /**
     * Display the specified resource.
     * @param Agreement $agreement
     *
     * @return Response
     */
    public function show(Agreement $agreement)
    {
        $agreement->load('user', 'attachments');

        return view('agreement_view', ['data' => ['agreement' => $agreement]]);
    }
}
