<?php

namespace App\Http\Controllers;

use App\Http\Requests\Contact\SubmitContact;
use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Contact  $contact
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
     * @param  \App\Models\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function submit(SubmitContact $request)
    {
        dd($request->all());
exit();
        $data = $request->all();

        return view('contact', ['data'=>$data]);
    }

}
