<?php

namespace App\Services;

use App\Models\Options;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

/**
 * @param Request $request
 */
class EmailMemberUpdateAddressService
{
    public function sendMessage($update_type, $message, $user)
    {
        $recipient = config('mail.admin.address');
        $cc = '';

        Log::debug('Member updating address. Config app env value is: '.config('app.env'));

        if (config('app.env') == 'local') {
            $recipient = config('mail.admin.address');
            $cc = Options::testing_address_update_contacts();
        }

        if (config('app.env') == 'production') {
            $recipient = config('mail.office_admin.address');
            $cc = Options::address_update_contacts();
        }

        Log::debug('EmailMemberUpdateAddressService update for '.$user->name.' Sending to: '.$recipient.', cc: '.
            implode(', ', $cc).' at '.date('Y-m-d H:i:s'));

        Mail::send('emails.user_address_update', ['update_type' => $update_type, 'data' => $message, 'user' => $user],
            function ($m) use ($update_type,
            $message,
            $user,
            $recipient,
            $cc) {
                $m->from(config('mail.from.address'), 'Local 118 Website');
                $m->to($recipient, $recipient);
                if ($cc != '') {
                    $m->cc($cc, $cc);
                }
                $m->replyTo($user->email, $user->name)
                ->subject(config('app.name').' Website '.$update_type.' Update For '.$user->name);
            });
    }
}
