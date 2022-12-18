<?php

namespace App\Http\Controllers;

use App\Http\Requests\Contact\SubmitContact;
use App\Models\Contact;
use App\Models\Options;
use App\Models\Page;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;
use ReCaptcha\ReCaptcha;
use SendGrid\Mail\TypeException;


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

        return view('contact', ['data' => $data]);
    }

    /**
     * @param SubmitContact $request
     * @return RedirectResponse
     * @throws TypeException
     */
    public function submit(SubmitContact $request): RedirectResponse
    {
        $recaptcha = new ReCaptcha(getenv('GOOGLE_RECAPTCHA_V3_SECRET_KEY'));

        $resp = $recaptcha->verify($request->input('g-recaptcha-response'), $request->ip());

        $sub_time = $request->session()->get('submission_time');

        if ($request->session()->get('suspicious') == 'true' && $sub_time->diffInMinutes(Carbon::now()) < 5) {
            Session::flash('error', 'Your submission appears suspicious.');

            return redirect()->route('contact');
        }

        $cc = config('app.env') == 'local' ? [] : Options::testing_address_update_contacts();

        if ($resp->isSuccess()) {
        } else {
            $errors = $resp->getErrorCodes();
        }

        if (($resp->getScore() < getenv('GOOGLE_RECAPTCHA_THRESHOLD')) && config('app.env') == 'production') {

            $request->session()->put('submission_time', Carbon::now());
            $request->session()->put('suspicious', 'true');

            Session::flash('warning', 'Your message was rejected by the Recaptcha filter.
                Please wait before trying again.');
        } else {
            Mail::send('emails.contact', ['data' => $request->all()], function ($m) use ($request, $cc) {
                $m->from(config('mail.from.address'), config('app.name') . 'Contact Page Message from '
                    . $request['name']);
                $m->to(config('mail.office_admin.address'), config('mail.office_admin.name'));
                if ($cc != '') {
                    $m->cc($cc, $cc);
                }
                $m->replyTo($request['email'], $request['name']);
                $m->subject('Contact Page ' . $request['subject']);
            });
                return redirect()->route('contact');
        }
    }
}
