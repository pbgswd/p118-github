<?php

namespace App\Http\Controllers\Admin;

use App\Constants\AccessLevelConstants;
use App\Http\Controllers\Controller;
use App\Http\Requests\Contactlist\StoreContactlistRequest;
use App\Http\Requests\Contactlist\UpdateContactlistRequest;
use App\Models\Contactlist;
use App\Models\Contactlistdata;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

class AdminContactlistController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $contactList = Contactlist::all();
        $contactListData = Contactlistdata::orderBy('name')->get();

        $data = [
            'contactlist' => $contactList[0],
            'contactlistdata' => $contactListData,
            'action' => 'list',
            'access_levels' => array_combine(AccessLevelConstants::getConstants(), AccessLevelConstants::getConstants()),
            'model_name' => 'Contactlist',
        ];

        return view('admin.contactlist', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
         dd(__METHOD__);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreContactlistRequest $request)
    {
        dd(__METHOD__);
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Contactlist $contactlist)
    {
        $contactList = Contactlist::all();

        $data = [
            'contactlist' => $contactList[0],
            'action' => 'edit',
            'access_levels' => array_combine(AccessLevelConstants::getConstants(), AccessLevelConstants::getConstants()),
            'model_name' => 'Contactlist',
        ];

        return view('admin.contactlist_edit', ['data' => $data]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateContactlistRequest $request, Contactlist $any_contactlist): RedirectResponse
    {
        $any_contactlist->fill($request->validated()['contactlist']);
        $any_contactlist->save();

        Session::flash('success', 'You have updated the Employer Contact Information Page');

        return redirect()->route('contactlist_list');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Contactlist $contactlist)
    {
        dd(__METHOD__);
    }
}
