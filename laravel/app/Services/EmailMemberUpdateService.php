<?php

namespace App\Services;

use App\Models\Options;
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

        $recipient = config('mail.admin.address');
        $cc = '';

        if (config('app.APP_ENV') == 'local') {
            $recipient = config('mail.admin.address');
            $cc = Options::testing_address_update_contacts();
        }

        if (config('app.APP_ENV') == 'production') {
            $recipient = config('mail.office_admin.address');
            $cc = Options::address_update_contacts();
        }

        Mail::send('emails.user_profile_update', ['data' => $message], function ($m) use ($message,
            $user,
            $recipient,
            $cc) {
            $m->from(config('mail.from.address'),  config('app.APP_NAME') .' Website profile update for '.$user->name);
            $m->to($recipient, $recipient);
            if ($cc != '') {
                $m->cc($cc, $cc);
            }
            $m->replyTo($user->email, $message['Name'] ?? $user->name)
                ->subject(config('app.APP_NAME') . ' - Member Contact Info Update for '.$message['original_name']);
        });
    }
}
