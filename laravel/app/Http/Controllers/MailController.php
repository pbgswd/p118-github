<?php

namespace App\Http\Controllers;

use App\Mail\DemoMail;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    public function index()
    {

        $mailData = [
            'title' => 'mail from petrerrrr p118',
            'body' => 'this is some sort of maildev test'
        ];

        Mail::to('superwebdeveloper@gmail.com')->send(new DemoMail($mailData));

        dd('email send successfully test 118');
    }
}
