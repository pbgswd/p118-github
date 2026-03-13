<?php

namespace App\Console\Commands;

use App\Models\QboToken;
use App\Services\QboService;
use Illuminate\Console\Command;

class RefreshQboToken extends Command
{
    protected $signature = 'qbo:refresh-token';
    protected $description = 'Force-refresh the QuickBooks Online access token';

    public function handle(): int
    {
        $token = QboToken::latest()->first();

        if (!$token) {
            $this->error('No QBO token found.');
            return Command::FAILURE;
        }

        try {
            (new QboService($token))->forceRefreshToken();
            $this->info("QBO token refreshed successfully (realm: {$token->realm_id}).");
            return Command::SUCCESS;
        } catch (\Exception $e) {
            $this->error('Failed to refresh token: ' . $e->getMessage());
            return Command::FAILURE;
        }
    }
}
