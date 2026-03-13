<?php

namespace App\Console\Commands;

use App\Models\QboToken;
use Illuminate\Console\Command;

class ClearQboToken extends Command
{
    protected $signature = 'qbo:clear-token';
    protected $description = 'Delete stored QBO token';

    public function handle(): int
    {
        QboToken::truncate();
        $this->info('The QBO token has been deleted.');
        return Command::SUCCESS;
    }
}
