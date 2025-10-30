<?php

namespace App\Http\Controllers\Admin;

use App\Constants\AccessLevelConstants;
use App\Http\Controllers\Controller;
use App\Http\Requests\Contactlistdata\DestroyContactlistdataRequest;
use App\Http\Requests\Contactlistdata\StoreContactlistdataRequest;
use App\Http\Requests\Contactlistdata\UpdateContactlistdataRequest;
use App\Models\Contactlistdata;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\View\View;

class AdminContactlistdataController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        dd(Contactlistdata::all());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $cldata = new Contactlistdata;

        $data = [
            'action' => 'Create',
            'cld' => $cldata,
            'access_levels' => array_combine(AccessLevelConstants::getConstants(), AccessLevelConstants::getConstants()),
            'model_name' => 'contactlistdata',
        ];

        return view('admin.contactlistdata_edit', ['data' => $data]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreContactlistdataRequest $request)
    {
        $contactlistdata = new Contactlistdata($request->input('cld'));
        $contactlistdata->save();

        Session::flash('success', 'You have saved the contact list entry.');

        return redirect()->route('contactlistdata_edit', [$contactlistdata->id]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Contactlistdata $any_contactlistdata): View
    {

        $data = [
            'action' => 'Edit',
            'cld' => $any_contactlistdata,
            'access_levels' => array_combine(AccessLevelConstants::getConstants(), AccessLevelConstants::getConstants()),
            'model_name' => 'contactlistdata',
        ];

        return view('admin.contactlistdata_edit', ['data' => $data]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateContactlistdataRequest $request, Contactlistdata $any_contactlistdata): RedirectResponse
    {
        $any_contactlistdata->fill($request->cld);
        $any_contactlistdata->save();
        Session::flash('success', 'You have edited the contact list entry.');

        return redirect()->route('contactlistdata_edit', [$any_contactlistdata->id]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DestroyContactlistdataRequest $request): RedirectResponse
    {
        Contactlistdata::withoutGlobalScopes()
            ->find($request->id)
            ->each(function (Contactlistdata $contactlistdata) {
                $contactlistdata->delete();
            });

        Session::flash('success', 'You have deleted '.count($request->id).' '.
            Str::plural('entry', count($request->id)).'.');

        return redirect()->route('contactlist_list');
    }
}
