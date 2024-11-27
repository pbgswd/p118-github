<?php

namespace App\Jobs;

use App\Models\EmailQueue;
use App\Models\Message;
use App\Models\MessageSending;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

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
     */
    public function handle(): void
    {
        Log::info('------------------------------------------------------------------------------------------------');
        Log::info('peter '.__METHOD__.' line '.__LINE__.
            ' - Start of handle method - Process message with id of: '.
            $this->taskData['id']);

        $message = Message::where('id', $this->taskData['id'])
            ->with('attachments')
            ->get();

        $attachments = ! is_null($message[0]->attachments) ?
            serialize($message[0]->attachments) : '';

        if (! is_null($attachments)) {
            Log::info('There is attachments data and its serialized length is '.
                strlen($attachments).' characters');
        } else {
            Log::info('There is no attachment data with this message');
            // 112 characters in length here
        }



        Log::info(__METHOD__.' line '.__LINE__.' - section= '.$message[0]->section.
            ', category= '.$message[0]->category);

        $subs = User::with('message_selections', 'type', $message[0]->section, 'name', $message[0]->category)
            ->get();

        //todo change column name in email_queue, it is content, not message
        foreach ($subs as $sub) {
            $emailQueueMsg = new EmailQueue([
                'message_id' => $message[0]->id,
                'user_id' => $subs->id,
            ]);

            $emailQueueMsg->save();

            Log::info(__METHOD__.' line '.__LINE__.' - The message, '.
                $message[0]->subject.
                ', is in the email queue');
        }



        //todo when the mail queue has been done, set the message send_status_now to sent

        //todo select the message to send
        // get attachment
        // build data with html template for message
        // check sending priority: if now, send to all

        //todo load messages for subscribers
        // into mail queue that have not already
        // been pushed to the mail queue

        Log::info(__FILE__.' line '.__LINE__.
            ' End of handle method - Process Messages Job was run '.
            $this->taskData['log'].'id: '.$this->taskData['id']);
    }
}
