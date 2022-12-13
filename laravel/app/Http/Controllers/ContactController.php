<?php

namespace App\Http\Controllers;

use App\Http\Requests\Contact\SubmitContact;
use App\Models\Contact;
use App\Models\Options;
use App\Models\Page;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
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
       // define('RECAPTCHA_V3_SECRET_KEY', '6Ldv4sQaAAAAADrmuSc0lzoaf-AiVMMES6LxAt7g');
        //define('RECAPTCHA_THRESHOLD', '0.5');

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
            $email = new \SendGrid\Mail\Mail();
            $email->setFrom(getenv('MAIL_FROM_ADDRESS'),  getenv('MAIL_FROM_NAME'));
            $email->setSubject('Contact Page '.$request['subject']);
            $email->addTo(getenv('MAIL_ADMIN_EMAIL'), getenv('MAIL_OFFICE_EMAIL_NAME'));
            $email->setReplyTo($request['email'], $request['name']);
            $email->addContent("text/plain", "you must view this message body as HTML");
            $email->addContent(
                "text/html", addslashes(view('emails.contact', ['data' => $request]))
            );
            $sendgrid = new \SendGrid(getenv('SENDGRID_API_KEY'));
            try {
                $response = $sendgrid->send($email);
                Session::flash('success', 'Your message was sent.');
            } catch (Exception $e) {
                echo 'Caught exception: '. $e->getMessage() ."\n";
            }
            $request->session()->pull('suspicious');
        }
        return redirect()->route('contact');
    }
}
