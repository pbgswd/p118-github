<?php

namespace App\Http\Controllers;

use App\Http\Requests\Committees\DestroyCommittee;
use App\Http\Requests\Committees\StoreCommittee;
use App\Http\Requests\Committees\UpdateCommittee;
use App\Models\Committee;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class AdminCommitteeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $c = Committee::with('creator')->sortable()->paginate(10);

        return view('admin.listcommittees', ['data' => array('committees' => $c)]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $committee = new Committee;
        $access_levels = $this->getFormOptions(['access_levels']);
        $data = [
            'user_id' => Auth::id(),
            'committee' => $committee,
        ];

        return view('admin.committee', ['data' => ['data' => $data, 'access_levels' => $access_levels, 'action' => 'Create']]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(StoreCommittee $request)
    {
        $data = $request->input('committee');
        $data['user_id'] = Auth::id();
        $committee = new Committee($data);
        $committee->save();

        Session::flash('success', "You have saved a new committee, " . $committee->name);

        return redirect()->route('committee_show', $committee->slug);
    }

    /**
     * Display the specified resource.
     *
     * @param Committee $committee
     * @return Response
     */
    public function show(Committee $committee)
    {
        $committee->creator;
        $committee['committee_levels'] = $this->getFormOptions(['committee_levels']);

        return view('admin.show_committee', ['data' => ['committee' => $committee, 'action' => 'View']]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Committee $committee
     * @return Response
     */
    public function edit(Committee $committee)
    {
        $committee->creator;

        $data = ['committee' => $committee];
        $access_levels = $this->getFormOptions(['access_levels']);

        return view('admin.committee', ['data' => ['data' => $data, 'access_levels' => $access_levels, 'action' => 'Edit']]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Committee $committee
     * @return Response
     */
    public function update(UpdateCommittee $request, Committee $committee)
    {
        $committee->fill($request->committee);
        $committee->save();

        Session::flash('success', "You have updated committee " . $committee->name);

        return redirect()->route('committee_edit', $committee->slug);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Committee $committee
     * @return Response
     */
    public function destroy(DestroyCommittee $request)
    {
        // set to... archive?
        // destroy committee relation?
        // destroy committee posts?
        // delete members?

        Committee::destroy($request->id);

        Session::flash('success', Str::plural('Committee', count($request->id)) . ' deleted.');

        return redirect()->route('committees_list');
    }
}
