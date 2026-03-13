<?php

namespace App\Services;

use App\Models\QboToken;
use QuickBooksOnline\API\DataService\DataService;
use Exception;
use QuickBooksOnline\API\Exception\SdkException;

class QboService
{
    protected DataService $dataService;
    protected QboToken $token;

    /**
     * @throws SdkException
     */
    public function __construct(?QboToken $token = null)
    {
        $this->token = $token
            ?? QboToken::latest()->first()
            ?? throw new Exception('No QBO token found. Please connect to QuickBooks Online first.');


        $dataService = DataService::Configure([
            'auth_mode'       => 'oauth2',
            'ClientID'        => config('qbo.client_id'),
            'ClientSecret'    => config('qbo.client_secret'),
            'accessTokenKey'  => $this->token->access_token,
            'refreshTokenKey' => $this->token->refresh_token,
            'QBORealmID'      => $this->token->realm_id,
            'baseUrl'         => config('qbo.base_url'),
        ]);

        if (!$dataService) {
            throw new Exception('Failed to configure QBO DataService.');
        }

        $this->dataService = $dataService;
        $this->dataService->throwExceptionOnError(true);

        if ($this->token->access_token_expires_at->isPast()) {
            $this->refreshToken();
        }
    }

    public function refreshToken(): void
    {
        $oauth2LoginHelper = $this->dataService->getOAuth2LoginHelper();
        $newToken = $oauth2LoginHelper->refreshAccessTokenWithRefreshToken($this->token->refresh_token);

        $this->token->update([
            'access_token'             => $newToken->getAccessToken(),
            'refresh_token'            => $newToken->getRefreshToken(),
            'access_token_expires_at' => now()->addSeconds($newToken->getAccessTokenExpiresAt()),
            'refresh_token_expires_at' => now()->addDays(100),
        ]);

        $this->dataService->updateOAuth2Token($newToken);
    }

    public function getDataService(): DataService
    {
        return $this->dataService;
    }

    public function query(string $query)
    {
        $this->requireConnection();
        return $this->dataService->Query($query);
    }

    public function isConnected(): bool
    {
        return QboToken::exists();
    }

    public function findCustomerByEmail(string $email)
    {
        $results = $this->query("SELECT * FROM Customer WHERE PrimaryEmailAddr = '{$email}'");
        return $results ? $results[0] : null;
    }

    protected function requireConnection(): void
    {
        if (!$this->isConnected()) {
            throw new \RuntimeException('QuickBooks is not connected. Please reconnect via the dashboard.');
        }
    }

    public function forceRefreshToken(): void
    {
        $this->refreshToken();
    }
}
