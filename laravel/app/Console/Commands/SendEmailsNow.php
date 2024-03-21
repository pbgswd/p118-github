<?php

namespace App\Console\Commands;

use App\Models\EmailQueue;
use App\Models\Message;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;


class SendEmailsNow extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'message:now';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send queued messages to subscribers who want messages right away.';

    /**
     * @return int
     */
    public function handle(): int
    {
       //todo select messages in queue, lined up with messages ready to go out
        $messages = EmailQueue::limit(5)->get();
        $messages = Message::where('sent', '=', 'send')->get();

        //users that want the message now.
        $subscribers = User::with('message_frequency_preferences', 'message_selections')
            ->whereRelation('message_frequency_preferences', 'preference', '=', 'now')
            ->get();

        foreach($messages as $message)
        {
            echo "type: " .$message->type . ", name: " . $message->name ."\n";

            foreach($subscribers as $sub)
            {
                echo $sub->email ."\n";
                // has subscriber been sent the message already?
                // insert into mail queue the $message with the email address for $sub


                //todo only build html, dont sent
                Mail::send('emails.email_message', ['data' => $request->all()], function ($m) use ($request, $cc) {
                    $m->from(config('mail.from.address'), config('app.name') . 'Contact Page Message from ' . $request['name']);
                    $m->to(config('mail.office_admin.address'), config('mail.office_admin.name'));
                    if ($cc != '') {
                        $m->cc($cc, $cc);
                    }
                    $m->replyTo($request['email'], $request['name']);
                    $m->subject('Contact Page ' . $request['subject'] . " from " . $request['name']);
                });
                //todo with attachments.







            }



        }

        //invoke mail sending service, send them out

        //delete the rows just mailed out

        Log::info('SendEmailsNow has run at ' . date('l jS \of F Y h:i:s A'));

        return Command::SUCCESS;
    }
}
