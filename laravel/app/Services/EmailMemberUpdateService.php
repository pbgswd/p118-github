<?php

namespace App\Services;

use Illuminate\Support\Facades\Mail;

/**
 * @param Request $request
 */

class EmailMemberUpdateService
{

    public function sendMessage($message, $user, $original_name)
    {
        $message['id'] = $user->id;
        $message['original_name'] = $original_name;
        $message['original_email'] = $user->email;

        $recipient = env('ADMIN_EMAIL');

        if (env('APP_ENV') == 'local') {
            $recipient = env('ADMIN_EMAIL');
            $cc = '';
        }

        if (env('APP_ENV') == 'production') {
            //todo admin email in .env, somewhere other than here
            $recipient = 'admin@iatse118.com';
            $cc = 'healthandwelfare@iatse118.com';
        }

        Mail::send('emails.user_profile_update', ['data' => $message], function ($m) use ($message,
            $user,
            $recipient,
            $cc) {
            $m->from(env('MAIL_FROM_ADDRESS'), "Local 118 Website profile update for ". $user->name);
            $m->to($recipient, $recipient);
            if($cc != '') {
                $m->cc($cc, $cc);
            }
            $m->replyTo($user->email, $message['Name'] ?? $user->name)
                ->subject("Local 118 - Member Contact Info Update for " . $message['original_name']);
        });
    }

}
