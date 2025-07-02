<?php

namespace App\Jobs;

use App\Models\Message;
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
    protected Message $taskData;

    public function __construct($taskData)
    {
        $this->taskData = $taskData;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // todo
        $message->state = 'sending';
        $message->save();

        Log::info('About to execute ProcessMessages dispatch for message with id '.$message->id);

        // ProcessMessages::dispatch(['id' => $message->id]);
        // Log::info('ProcessMessages dispatch has been executed for message with id '.$message->id);

    }
}
