<?php

namespace App\Http\Controllers;

use App\Http\Requests\Contact\SubmitContact;
use App\Models\Contact;
use App\Models\Options;
use App\Models\Page;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

class ContactController extends Controller
{
    /**
     * @param Contact $contact
     * @return View
     */
    public function show(Contact $contact): View
    {
        $data = [];

        if (Auth::user()) {
            $data = ['contactPage' => Page::withoutGlobalScopes()
                ->where('slug', 'contact-us')->get()];
        }

        return view('contact', ['data' => $data]);
    }

    /**
     * @param SubmitContact $request
     * @return RedirectResponse
     */
    public function submit(SubmitContact $request): RedirectResponse
    {
        $cc = '';
        if (env('APP_ENV') == 'local') {
            $cc = Options::testing_address_update_contacts();
        }

        Mail::send('emails.contact', ['data' => $request->all()], function ($m) use ($request, $cc) {
            $m->from(env('MAIL_FROM_ADDRESS'), 'Local 118 Contact Page Message from '
                .$request['name']);
            $m->to(env('ADMIN_EMAIL'), env('ADMIN_EMAIL_NAME'));
            if ($cc != '') {
                $m->cc($cc, $cc);
            }
            $m->replyTo($request['email'], $request['name']);
            $m->subject('Contact Page '.$request['subject']);
        });

        Session::flash('success', 'Your message was sent.');

        return redirect()->route('contact');
    }
}
