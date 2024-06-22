<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SendEmailsWeekly extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'message:weekly';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send queued messages to subscribers who want messages once a week.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        return Command::SUCCESS;
    }
}
