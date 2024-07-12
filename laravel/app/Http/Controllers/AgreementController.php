<?php

namespace App\Http\Controllers;

use App\Models\Agreement;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

//use App\Services\AgreementService;

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
                ->orderBy('until', 'desc')
                ->sortable()
                ->paginate(20);

            $data['count'] = Agreement::where([['live', 1], ['access_level', 'public']])->count();
        } else {
            $data['agreements'] = Agreement::where('live', 1)
                ->sortable()
                ->orderBy('until', 'desc')
                ->paginate(20);

            $data['count'] = Agreement::where('live', 1)->count();
        }

        return view('agreements_list', ['data' => ['data' => $data, 'title' => "Collective Agreements"]]);
    }

    public function show(Agreement $agreement): View
    {
        $agreement->load('user', 'attachments', 'organizations', 'venues');

        return view('agreement_view', ['data' => ['agreement' => $agreement, 'title' => $agreement->title]]);
    }
}
