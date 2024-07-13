<?php

namespace App\Http\Controllers;

use App\Models\Bylaw;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ByLawController extends Controller
{
    public function list(): View
    {
        $data = [];
        if (Auth::check()) {
            $data['bylaws'] = Bylaw::where('live', 1)
                ->sortable()
                ->with('attachments')
                ->orderBy('date', 'desc')
                ->paginate(30);

            $data['count'] = Bylaw::count();
        } else {
            $data['bylaws'] = Bylaw::sortable()
                ->where([['access_level', 'public'], ['live', 1]])
                ->with('attachments')
                ->orderBy('date', 'desc')
                ->paginate(30);

            $data['count'] = Bylaw::where('access_level', 'public')->count();
        }

        return view('bylaws_list', ['data' => ['data' => $data,
            'title' => 'Constitution and Bylaws']]);
    }

    public function show(Bylaw $bylaw): View
    {
        $bylaw->load('user', 'attachments');

        return view('bylaw_view', ['data' => ['bylaw' => $bylaw,
            'title' =>  $bylaw->title .' -  Constitution and Bylaws']]);
    }
}
