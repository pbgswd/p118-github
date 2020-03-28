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
            'meetings' => Meeting::sortable()->with('user')->orderBy('date', 'desc')->paginate(20),
            'count' => Meeting::count(),
        ];

        return view('list_meetings_minutes', ['data' => $data]);
    }


    /**
     * Display the specified resource.
     *
     * @param Meeting $meeting
     * @return Response
     */
    public function show(Meeting $meeting): Response
    {
        $meeting->load('user', 'attachments');

        return view('meeting', ['data' => ['meeting' => $meeting]]);
    }
}
