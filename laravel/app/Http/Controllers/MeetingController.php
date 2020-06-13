<?php

namespace App\Http\Controllers;

use App\Models\Meeting;
use Illuminate\Http\Response;


class MeetingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $data = [
            'meetings' => Meeting::withoutGlobalScopes()
                ->sortable()->with('user')->orderBy('date', 'desc')->paginate(20),
            'count' => Meeting::withoutGlobalScopes()->count(),
        ];

        return view('list_meetings_minutes', ['data' => $data]);
    }


    /**
     * @param Meeting $meeting
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Meeting $meeting)
    {
        $meeting->load('user', 'attachments');

        return view('meeting', ['data' => ['meeting' => $meeting]]);
    }
}
