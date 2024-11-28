<?php

namespace App\Jobs;

use App\Models\EmailQueue;
use App\Models\Message;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ProcessMessages implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable;

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
        $message = Message::where('id', $this->taskData['id'])
            ->with('attachments')
            ->get();

        Log::info('subject: ' . $message->subject);

        Log::info(__METHOD__.' line '.__LINE__.' - section= '.$message->section.
            ', category= '.$message->category);

        $subs = User::whereHas('message_selections', function ($query) {
            $query->where('type', 'model')
                ->where('name', 'message');
        })->get();


        foreach ($subs as $sub) {
            $emailQueueMsg = new EmailQueue([
                'message_id' => $message->id,
                'user_id' => $subs->id,
            ]);
            $emailQueueMsg->save();
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
