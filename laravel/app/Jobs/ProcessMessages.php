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



        foreach($subscribers as $sub) {
            //todo  build message with subscriber
            // message body needs html template




            // later with attachment
            $emailMsg = new EmailQueue([
                'sender' => env('MAIL_FROM_ADDRESS'),
                'recipient' => $sub->user->email,
                'subject' => $message[0]->subject,
                'message' => $message[0]->content,
                'attachments' => $attachments
            ]);

            $emailMsg->save();
            //save an instance of the message in the mail queue with the subscriber email
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
