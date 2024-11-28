<?php

namespace App\Jobs;

use App\Models\EmailQueue;
use App\Models\Message;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
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


        //todo
        $message->state = 'sending';
        $message->save();

        Log::info('About to execute ProcessMessages dispatch for message with id '.$message->id);

        // ProcessMessages::dispatch(['id' => $message->id]);
        // Log::info('ProcessMessages dispatch has been executed for message with id '.$message->id);

        $subs = User::where( 'is_banned', '!=', 1)
            ->whereHas('message_selections', function ($query) use ($message) {
            $query->where('type', $message->section)->where('name', $message->category);
        })->get();

        foreach ($subs as $sub) {
            $emailQueueMsg = new EmailQueue([
                'message_id' => $message->id,
                'user_id' => $sub->id,
            ]);
            $emailQueueMsg->save();
        }


    }
}
