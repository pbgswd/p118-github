<?php

namespace App\Console\Commands;

use App\Models\Employment;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class UpdateEmploymentStatusCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'employment:update-status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sets status for job postings in relation to expiry date';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
     Log::debug('running command ' . __CLASS__ . ' ' . date('Y-m-d H:i:s'));

        Employment::where([
            ['deadline', '<', now()],
            ['status', '=', 1]
        ])->update(['status' => 0]);

        Employment::where('deadline', '>', now())
            ->update(['status' => 1]);

        $this->info('Successfully ran the command for expiry date check for job postings.');
    }
}
