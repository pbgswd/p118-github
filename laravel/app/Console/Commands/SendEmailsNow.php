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
        //$messages = Message::where('sent', '=', 'send')->get();



        foreach($messages as $message)
        {
            echo "\n EmailQueue message id: " .$message->id . ", Subject: " . $message->subject ."\n";


            if($message->attachments != '') {
                $attachments = unserialize($message->attachments);
                //todo prep attachments for mail message
                foreach($attachments as $att)
                {
                    //todo read attachments
                }
            }


                echo "\n \t" . $message->recipient . "\n";
                // has subscriber been sent the message already?
                // insert into mail queue the $message with the email address for $sub


                /**
                Mail::send($message->message, [], function ($m) use ($message) {
                    $m->from(config('mail.from.address'), config('app.name') . 'Subscription message local 118');
                    $m->to($message->email, 'name of somebody');
                    $m->replyTo($message['recipient'], 'recipient');
                    $m->subject('IATSE Local 118: ' . $message['subject']);
                 *
                 *
                 * $m->attach()
                });
                */
                //todo with attachments.

            //todo delete message
            EmailQueue::where('id', $message->id)->delete();
        }

        //invoke mail sending service, send them out

        //delete the rows just mailed out

        Log::info('SendEmailsNow has run at ' . date('l jS \of F Y h:i:s A'));

        return Command::SUCCESS;
    }
}
