<?php

namespace App\Console\Commands;

use App\Models\EmailQueue;
use App\Models\Message;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

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

    public function handle(): int
    {
        $messageLimit = 5;
        $message = Message::where('state', 'sending')->first();

        $subs = EmailQueue::with('user')->where('message_id', $message->id)->limit($messageLimit)->get();

        foreach($subs as $sub) {

            $data['message']['id'] = $message->id;
            $data['message']['slug'] = $message->slug;
            $data['message']['sender'] = env('MAIL_FROM_ADDRESS');
            $data['message']['subject'] = $message->subject;
            $data['message']['content'] = $message->content;

            $data['attachments'] = [];

            Mail::send('emails.email_message', ['data' => $data], function ($m) use ($message, $sub) {
                $m->from(env('MAIL_FROM_ADDRESS'), config('app.name').'Subscription message local 118');
                $m->to($sub->user->email, $sub->user->name);
                $m->replyTo(config('mail.from.address'), 'no reply to guy');
                $m->subject('IATSE Local 118: '.$message->subject);

/*
 *                 $attachments = unserialize($message->attachments);
                if ($attachments->count() > 0) {

                    foreach ($attachments as $att) {
                        $file = 'storage/app/'.$message->getAttachmentFolder().'/'.$att->file;
                        $mime = mime_content_type($file);
                        $file_name = $att->file_name;

                        $m->attach($file, ['as' => $file_name, 'mime' => $mime]); // yes but always hash file name
                    }
                }*/

            });

            EmailQueue::where('id', $message->id)->delete();
//todo update the count of the messages sent
        }
        //todo if there are no more messages to send, set state to sent

        //  Log::info('SendEmailsNow has run at '. date('l jS \of F Y h:i:s A') . ', ' . $messages->count() . " " . Str::plural('message', $messages->count()) .  ' selected to send');

        return Command::SUCCESS;
    }
}
