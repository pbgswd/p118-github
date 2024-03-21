<?php

namespace App\Jobs;

use App\Models\EmailQueue;
use App\Models\Message;
use App\Models\MessageFrequencyPreferences;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;


class ProcessMessages implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */

    protected $taskData;
    public function __construct($taskData)
    {
        $this->taskData = $taskData;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(): void
    {
            // or sent = send
        $message = Message::where('id', $this->taskData['id'])
            ->with('attachments')
            ->get();

        $attachments = $message[0]->attachments !='' ? serialize($message[0]->attachments) : '';

        //todo get any related info about where the message resource comes from
        // is it a model, a topic page|post, committee?
        // is it a model, a topic page|post, committee?

        $subscribers = MessageFrequencyPreferences::where('preference', 'now')
            ->with('user')
            ->get();

        //assuming 1 message

        foreach($subscribers as $sub) {
            $emailQueueMsg = new EmailQueue([
                'sender' => env('MAIL_FROM_ADDRESS'),
                'recipient' => $sub->user->email,
                'subject' => $message[0]->subject,
                'message' => View::make('emails.email_message', $message[0]),
                'attachments' => $attachments
            ]);

            $emailQueueMsg->save();

            Log::info('The message, ' . $message[0]->subject . ', is in the email queue to '. $sub->user->email);
        }

        //todo artisan task sends message using EmailMessageSendService

        //todo select the message to send
        // get attachment
        // build data with html template for message
        // check sending priority: if now, send to all

        //todo load messages for subscribers
        // into mail queue that have not already
        // been pushed to the mail queue

        Log::info('Process Messages Job was run ' . $this->taskData['log'] . 'id: '.$this->taskData['id']);
    }
}
