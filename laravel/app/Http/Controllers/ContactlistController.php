<?php

namespace App\Http\Controllers;

use App\Models\Contactlist;
use App\Models\Contactlistdata;
use Illuminate\Http\Request;
//  \App\Models\Contactlist::factory()->make();
class ContactlistController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $contactlist = Contactlist::all();
        $contactlistdata = Contactlistdata::all();
        $data = [
            'contactlist' => $contactlist,
            'contactlistdata' => $contactlistdata,
            ];

        return view('employer_list', ['data' => $data]);

    }


}
