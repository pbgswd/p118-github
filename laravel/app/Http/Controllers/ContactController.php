<?php

namespace App\Http\Controllers;

use App\Http\Requests\Contact\SubmitContact;
use App\Models\Contact;
use App\Models\Options;
use App\Models\Page;
use Carbon\Carbon;
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
        $data = [];

        if (Auth::user()) {
            $data = ['contactPage' => Page::withoutGlobalScopes()
                ->where('slug', 'contact-us')->get(), ];
        }

        Log::debug('Contact page visited  at '.date('Y-m-d H:i:s')."\n \n \n");

        return view('contact', ['data' => $data]);
    }

    /**
     * @param SubmitContact $request
     * @return RedirectResponse
     */
    public function submit(SubmitContact $request): RedirectResponse
    {
        Log::debug("---------------------------------- \n");
        Log::debug("\n" . __METHOD__ . ' method hit, Contact page message submitted from ' .
            $request['name'] .
            ' sending to: ' .
            config('mail.office_admin.address') . ' ' .
            config('mail.office_admin.name') . ' at ' .
            date('Y-m-d H:i:s') . "\n");

        define('RECAPTCHA_V3_SECRET_KEY', '6Ldv4sQaAAAAADrmuSc0lzoaf-AiVMMES6LxAt7g');
        define('RECAPTCHA_THRESHOLD', '0.5');

        $recaptcha = new ReCaptcha(RECAPTCHA_V3_SECRET_KEY);

        $resp = $recaptcha->verify($request->input('g-recaptcha-response'), $request->ip());

        Log::debug("---------------------------------- \n");
        Log::debug("\n" . 'Contact form Recaptcha v.3 score=' . $resp->getScore() . "\n");

        $sub_time = $request->session()->get('submission_time');

        if ($request->session()->get('suspicious') == 'true' && $sub_time->diffInMinutes(Carbon::now()) < 5) {
            Session::flash('error', 'Your submission appears suspicious.');

            return redirect()->route('contact');
        }

        $cc = config('app.env') == 'local' ? [] : Options::testing_address_update_contacts();

        Log::debug("---------------------------------- \n");
        Log::debug('Contact page message from '.$request['name'].
            ' sending to: '.
            config('mail.office_admin.address').' '.
            config('mail.office_admin.name').', cc: '.
            implode(', ', $cc).
            ' at '.
            date('Y-m-d H:i:s')."\n");

        if ($resp->isSuccess()) {
            Log::debug("---------------------------------- \n");
            Log::debug('Contact form Recaptcha v.3 score='.$resp->getScore().' submission from '.
                $request->name." was returned as a success. \n");
        } else {
            $errors = $resp->getErrorCodes();
            Log::debug("---------------------------------- \n");
            Log::debug('Errors from Contact form Recaptcha v.3 from '.
                $request->name.': '.
                serialize($errors)."\n");
        }
        Log::debug("---------------------------------- \n");
        Log::debug('Contact form submission data from '.$request->name.' '.serialize($resp)."\n");

        if (($resp->getScore() < RECAPTCHA_THRESHOLD) && config('app.env') == 'production') {
            Log::debug("---------------------------------- \n");
            Log::debug('Contact form recaptcha score was low = '.$resp->getScore()."\n");

            $request->session()->put('submission_time', Carbon::now());
            $request->session()->put('suspicious', 'true');

            Session::flash('warning', 'Your message was rejected by the Recaptcha filter.
                Please wait before trying again.');
        } else {
            Mail::send('emails.contact', ['data' => $request->all()], function ($m) use ($request, $cc) {
                $m->from(config('mail.from.address'), config('app.name').'Contact Page Message from '
                    .$request['name']);
                $m->to(config('mail.office_admin.address'), config('mail.office_admin.name'));
                if ($cc != '') {
                    $m->cc($cc, $cc);
                }
                $m->replyTo($request['email'], $request['name']);
                $m->subject('Contact Page '.$request['subject']);
            });

            Session::flash('success', 'Your message was sent.');
            $request->session()->pull('suspicious');
        }

        return redirect()->route('contact');
    }
}
