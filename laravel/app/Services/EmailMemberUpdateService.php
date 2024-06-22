<?php

namespace App\Services;

use App\Models\Options;
use Illuminate\Support\Facades\Mail;

/**
 * @param  Request  $request
 */
class EmailMemberUpdateService
{
    public function sendMessage($message, $user)
    {
        $message['id'] = $user->id;

        $recipient = config('mail.admin.address');
        $cc = '';

        if (config('app.env') == 'local') {
            $recipient = config('mail.admin.address');
            $cc = Options::testing_address_update_contacts();
        }

        if (config('app.env') == 'production') {
            $recipient = config('mail.office_admin.address');
            $cc = Options::address_update_contacts();
        }

        Mail::send('emails.user_profile_update', ['data' => $message], function ($m) use (
            $user,
            $recipient,
            $cc) {
            $m->from(config('mail.from.address'), config('app.name').' Website profile update for '.$user->name);
            $m->to($recipient, $recipient);
            if ($cc != '') {
                $m->cc($cc, $cc);
            }
            $m->replyTo($user->email, $user->name)
                ->subject(config('app.name').' - Member Contact Info Update for '.$user->name);
        });
    }
}
