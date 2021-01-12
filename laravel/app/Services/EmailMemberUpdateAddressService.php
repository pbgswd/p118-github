<?php

namespace App\Services;

use Illuminate\Support\Facades\Mail;

/**
 * @param Request $request
 */

class EmailMemberUpdateAddressService
{

    public function sendMessage($message, $user)
    {
        $recipient = env('ADMIN_EMAIL');
        $cc = '';

        if (env('APP_ENV') == 'local') {
            $recipient = env('ADMIN_EMAIL');
        }

        if (env('APP_ENV') == 'production') {
            //todo admin email in .env, somewhere other than here
            $recipient = 'admin@iatse118.com';
            $cc = 'healthandwelfare@iatse118.com';
        }

        Mail::send('emails.user_address_update', ['data' => $message, 'user' => $user], function ($m) use ($message,
            $user,
            $recipient,
            $cc) {
            $m->from(env('MAIL_FROM_ADDRESS'), "Local 118 Website");
            $m->to($recipient, $recipient);
            if($cc != '') {
                $m->cc($cc, $cc);
            }
            $m->replyTo($user->email, $user->name)
                ->subject("Local 118 - Address Update for " . $user->name);
        });
    }

}
