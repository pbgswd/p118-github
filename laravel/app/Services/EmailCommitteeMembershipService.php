<?php

namespace App\Services;

use App\Models\Options;
use Illuminate\Support\Facades\Mail;

class EmailCommitteeMembershipService
{
    public function sendMessage($data)
    {
        $replyTo = $data['committee']->email;
        $recipient = $data['user']['email'];

        $cc = '';

        if (env('APP_ENV') == 'local') {
            $recipient = env('ADMIN_EMAIL');
            $cc = Options::testing_address_update_contacts();
        }

        Mail::send('emails.user_committee_join_notice', ['data' => $data], function ($m) use (
            $recipient,
            $replyTo,
            $cc) {
            $m->from(env('MAIL_FROM_ADDRESS'), 'Local 118 Website Committee Notification');
            $m->to($recipient, $recipient);
            if ($cc != '') {
                $m->cc($cc, $cc);
            }
            $m->subject('Local 118 Website Committee Notification')
                ->replyTo($replyTo, $replyTo);
        });
    }
}
