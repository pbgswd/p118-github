<?php

namespace App\Services;

use Illuminate\Support\Facades\Mail;

class EmailCommitteeMembershipService
{
    public function sendMessage($data)
    {
        $replyTo = $data['committee']->email;
        $recipient = $data['user']['email'];

        Mail::send('emails.user_committee_join_notice', ['data' => $data], function ($m) use (
            $recipient,
            $replyTo) {
                $m->from(env('MAIL_FROM_ADDRESS'), "Local 118 Website Committee Notification")
                ->to($recipient, $recipient)
                ->subject("Local 118 Website Committee Notification")
                ->replyTo($replyTo, $replyTo);
        });
    }
}
