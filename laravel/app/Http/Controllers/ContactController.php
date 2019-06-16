<?php

namespace App\Http\Controllers;

use App\Http\Requests\Contact\SubmitContact;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

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

        dump($request->all());
      //  echo $_ENV['ADMIN_EMAIL'];
dump(env('ADMIN_EMAIL'));
dump(env('ADMIN_EMAIL_NAME'));
dump(env('APP_NAME'));
dump(config('ADMIN_EMAIL'));
        dd(config('app.env'));
        exit();

        Mail::send('emails.contact', ['data'=>$request->all()], function ($m) use ($request) {
            $m->from($request['email'], $request['name']);
            $m->to(env('ADMIN_EMAIL'), env('ADMIN_EMAIL_NAME'))->subject('Contact Page ' . $request['subject']);
        });

        flash()->success('Your message was sent.');
        return view('contact', ['data'=>array()]);
    }

}
