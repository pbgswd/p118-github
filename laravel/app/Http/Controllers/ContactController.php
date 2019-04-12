<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param  \App\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function show(Contact $contact)
    {
        $data = [];
        return view('contact', ['data'=>$data]);

    }

    /**
     * Submit the form to send email.
     *
     * @param  \App\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function submit(Request $request)
    {
        dd($request->all());
        $data = [];
        return view('contact', ['data'=>$data]);
    }

}
