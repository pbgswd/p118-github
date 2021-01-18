<?php

namespace App\Http\Controllers;

use App\Models\Meeting;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Response;
use Illuminate\View\View;

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
     * @return Factory|View
     */
    public function show(Meeting $meeting)
    {
        $meeting->load('user', 'attachments');

        return view('meeting', ['data' => ['meeting' => $meeting]]);
    }
}
