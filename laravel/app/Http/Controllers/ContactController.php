<?php

namespace App\Http\Controllers;

use App\Http\Requests\Contact\SubmitContact;
use App\Models\Contact;
use App\Models\Options;
use App\Models\Page;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;
use ReCaptcha\ReCaptcha;

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
        define("RECAPTCHA_V3_SECRET_KEY", '6Ldv4sQaAAAAADrmuSc0lzoaf-AiVMMES6LxAt7g');

        $cc = [];

        if (config('app.env')  == 'local') {
            $cc = Options::testing_address_update_contacts();
        }

        Log::debug('Contact page message from ' . $request['name'] . ' sending to: ' .
            config('mail.office_admin.address') . ' ' . config('mail.office_admin.name') .', cc: ' .
            implode(", ", $cc) . ' at ' . date('Y-m-d H:i:s'));

        $recaptcha = new ReCaptcha(RECAPTCHA_V3_SECRET_KEY);

        $resp = $recaptcha->verify($request->input('g-recaptcha-response'), $request->ip());
        Log::debug("Contact form Recaptcha v.3 score=".$resp->getScore());

        if ($resp->isSuccess()) {
            Log::debug("Contact form Recaptcha v.3 score=".$resp->getScore() . " submission from ".
                $request->name ." was returned as a success.");
        } else {
            $errors = $resp->getErrorCodes();
            Log::debug("Errors from Contact form Recaptcha v.3 from ". $request->name . ": ". serialize($errors));
        }

        Log::debug("Contact form submission data from ". $request->name . " " . serialize($resp));

        if($resp->getScore() < 1) {
            Log::debug('Contact form recaptcha score was low = '. $resp->getScore());
            usleep(250000);
        }

        usleep(250000);

        Mail::send('emails.contact', ['data' => $request->all()], function ($m) use ($request, $cc) {
            $m->from( config('mail.from.address'), config('app.name') . 'Contact Page Message from '
                . $request['name']);
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
