<?php

namespace App\Http\Controllers;

use App\Models\Agreement;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

// use App\Services\AgreementService;

class AgreementController extends Controller
{
    /**
     * @param  AgreementService  $service
     */
    /**
        public function list_demo(AgreementService $service): View
        {
            $data = [];

            $data['agreements'] = $service->get_parent_list();


            //todo data when Auth::check() == false

            // todo data count


            //todo data when Auth::check() == true

            // todo data count

            return view('agreements_list', ['data' => $data]);

        }
     **/
    public function list(): View
    {
        $data = [];

        if (Auth::check() == false) {
            $data['agreements'] = Agreement::where([['live', 1], ['access_level', 'public']])
                ->orderBy('title', 'asc')
                ->sortable()
                ->paginate(50);

            $data['count'] = Agreement::where([['live', 1], ['access_level', 'public']])->count();
        } else {
            $data['agreements'] = Agreement::where('live', 1)
                ->sortable()
                ->orderBy('title', 'asc')
                ->paginate(50);

            $data['count'] = Agreement::where('live', 1)->count();
        }

        $data['current'] = Agreement::where([['live', 1], ['until', '>', now()]])->count();

        return view('agreements_list', ['data' => ['data' => $data, 'title' => 'Collective Agreements']]);
    }

    public function show(Agreement $agreement): View
    {
        $agreement->load('user', 'attachments', 'organizations', 'venues');

        if (Auth::check() == false) {
            $next = Agreement::where('id', '>', $agreement->id)
                ->where([['live', 1], ['access_level', 'public']])
                ->orderBy('id', 'asc')
                ->first();

            $previous = Agreement::where('id', '<', $agreement->id)
                ->where([['live', 1], ['access_level', 'public']])
                ->orderBy('id', 'desc')
                ->first();
        } else {
            $next = Agreement::where('id', '>', $agreement->id)
                ->where('live', 1)
                ->orderBy('id', 'asc')
                ->first();

            $previous = Agreement::where('id', '<', $agreement->id)
                ->where('live', 1)
                ->orderBy('id', 'desc')
                ->first();
        }

        return view('agreement_view', ['data' => [
            'agreement' => $agreement,
            'title' => $agreement->title,
            'next' => $next,
            'previous' => $previous,
        ],
        ]);
    }
}
