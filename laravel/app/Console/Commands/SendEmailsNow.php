<?php

namespace App\Console\Commands;

use App\Models\EmailQueue;
use App\Models\Message;
use App\Models\User;
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
        $messageLimit = 10;

        $message = Message::whereIn('state', ['sending', 'testing'])->first();

        if($message) {
            $message->load('attachments', 'messageCategories');

            $data['message']['id'] = $message->id;
            $data['message']['slug'] = $message->slug;
            $data['message']['sender'] = env('MAIL_FROM_ADDRESS');
            $data['message']['subject'] = $message->subject;
            $data['message']['content'] = $message->content;
            $data['attachments'] = $message->attachments ?? 0;

	    if($message->state == 'sending') {
	        $subs = EmailQueue::distinct()->with('user')
            	    ->where('message_id', $message->id)
		    ->limit($messageLimit)
                    ->get();
           }

	   if($message->state == 'testing') {
               $subs = EmailQueue::with('user')
	       ->where([['message_id',$message->id],['user_id', $message->user_id]])
	       ->get();
	   }

//todo error, check it with both mailpit and aws
            foreach($subs as $sub) {
                Mail::send('emails.email_message', ['data' => $data], function ($m) use ($message, $sub, $data) {
                    $m->from(env('MAIL_FROM_ADDRESS'), config('app.name') .' - '. $message->subject);
                    $m->to($sub->user->email, $sub->user->name);
                    $m->replyTo(config('mail.from.address'), config('app.name'));
                    $m->subject($message->subject);

                    if ($message->attachments->count() > 0) {
                        foreach ($message->attachments as $att) {
			
                            $file = 'storage/app/' . $att->subfolder . '/' . $att->file;

			    $mime = mime_content_type(getcwd()."/".$file);
                            $file_name = $att->file_name;
                            $m->attach($file, ['as' => $file_name, 'mime' => $mime]);
                        }
                    }
                });

                if($message->state == 'sending') {
                    $message->increment('count');

                    EmailQueue::where('user_id', $sub->user->id)
                        ->where('message_id', $message->id)
                        ->delete();
                }

		if($message->state != 'testing') {
                    if (EmailQueue::where('message_id', $message->id)->count() == 0) {
                        $message->state = 'sent';
                        $message->save();
                    }
                }

		if($message->state == 'testing') {
		     EmailQueue::where([['message_id',$message->id],['user_id', $message->user_id]])
		     ->delete();
		     $message->state = 'not_sent';
                     $message->save();
		}
            }
        }
        return Command::SUCCESS;
    }
}
