<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UpdateExecutiveCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'executive:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update property for current column in executives table';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $this->info('Update any expired executive status');
        Log::debug('running artisan command '.__CLASS__);
        $data = DB::select('SELECT * FROM executive_user WHERE end_date < now()');
        //todo closure
        foreach ($data as $d) {
            if ($d->current == 1) {
                $result = DB::update('UPDATE executive_user SET current=0 WHERE id='.$d->id);
            }
        }
    }
}
