<?php

namespace App\Http\Controllers;

use App\Http\Requests\Contact\SubmitContact;
use App\Models\Contact;
use App\Models\Page;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class ContactController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param Contact $contact
     * @return Response
     */
    public function show(Contact $contact)
    {
        $data = [];

        if(Auth::user()) {
            $data = ['contactPage' => Page::withoutGlobalScopes()->where('slug', 'local-118-contacts')->get()];
        }

        return view('contact', ['data' => $data]);
    }

    /**
     * Submit the form to send email.
     *
     * @param Contact $contact
     * @return Response
     */
    public function submit(SubmitContact $request)
    {

        Mail::send('emails.contact', ['data' => $request->all()], function ($m) use ($request) {
            $m->from($request['email'], $request['name']);
            $m->to(env('ADMIN_EMAIL'), env('ADMIN_EMAIL_NAME'))
                ->subject('Contact Page ' . $request['subject']);
        });

        Session::flash('success', 'Your message was sent.');

        return view('contact', ['data' => []]);
    }

}
