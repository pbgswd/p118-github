<?php

namespace App\Services;

use App\Models\Options;
use Illuminate\Support\Facades\Mail;

/**
 * @param Request $request
 */
class EmailMemberUpdateAddressService
{
    public function sendMessage($update_type, $message, $user)
    {
        $recipient = env('ADMIN_EMAIL');
        $cc = '';

        if (env('APP_ENV') == 'local') {
            $recipient = env('ADMIN_EMAIL');
            $cc = Options::testing_address_update_contacts();
        }

        if (env('APP_ENV') == 'production') {
            //todo admin email in .env, somewhere other than here
            $recipient = 'admin@iatse118.com';
            $cc = Options::address_update_contacts();
        }

        Mail::send('emails.user_address_update', ['update_type' => $update_type, 'data' => $message, 'user' => $user],
            function ($m) use ($update_type,
            $message,
            $user,
            $recipient,
            $cc) {
            $m->from(env('MAIL_FROM_ADDRESS'), 'Local 118 Website');
            $m->to($recipient, $recipient);
            if ($cc != '') {
                $m->cc($cc, $cc);
            }
            $m->replyTo($user->email, $user->name)
                ->subject(env('APP_NAME') . ' Website ' . $update_type . ' Update For ' . $user->name);
        });
    }
}
