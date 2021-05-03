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
        usleep(250000);
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
        usleep(250000);
        $cc = '';
        if (config('app.APP_ENV') == 'local') {
            $cc = Options::testing_address_update_contacts();
        }
// https://developers.google.com/recaptcha/docs/verify
        // recaptcha secret: 6Ldv4sQaAAAAAJApVGt3T9XUyZcNFDrKLS_Umu1A

        Mail::send('emails.contact', ['data' => $request->all()], function ($m) use ($request, $cc) {
            $m->from( config('mail.from.address'), config('app.APP_NAME') . 'Contact Page Message from '
                .$request['name']);
            $m->to(config('mail.office_admin.address'), config('mail.office_admin.name'));
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
