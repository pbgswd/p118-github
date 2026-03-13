<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\QboToken;
use Illuminate\Support\Facades\Session;
use QuickBooksOnline\API\DataService\DataService;

class QboAuthController extends Controller
{
    public function redirect()
    {
        try {
            $dataService = DataService::Configure([
                'auth_mode'     => 'oauth2',
                'ClientID'      => config('qbo.client_id'),
                'ClientSecret'  => config('qbo.client_secret'),
                'RedirectURI'   => config('qbo.redirect_uri'),
                'scope'         => config('qbo.scope'),
                'baseUrl'       => config('qbo.base_url'),
            ]);

            $oauth2LoginHelper = $dataService->getOAuth2LoginHelper();
            $authUrl = $oauth2LoginHelper->getAuthorizationCodeURL();

            session(['qbo_oauth_state' => $oauth2LoginHelper->getState()]);

            return redirect($authUrl);
        } catch (\Throwable $e) {
            return redirect()->route('qbo.dashboard')->with('qbo_error', 'Could not connect to QuickBooks. Please check your configuration and try again.');
        }
    }

    public function callback()
    {
        $sessionState = session()->pull('qbo_oauth_state');
        if (!$sessionState || !hash_equals($sessionState, (string) request('state'))) {
            return redirect()->route('qbo.dashboard')->with('qbo_error', 'Invalid OAuth state. Please try connecting again.');
        }

        try {
            $dataService = DataService::Configure([
                'auth_mode'     => 'oauth2',
                'ClientID'      => config('qbo.client_id'),
                'ClientSecret'  => config('qbo.client_secret'),
                'RedirectURI'   => config('qbo.redirect_uri'),
                'scope'         => config('qbo.scope'),
                'baseUrl'       => config('qbo.base_url'),
            ]);

            $oauth2LoginHelper = $dataService->getOAuth2LoginHelper();

            $accessToken = $oauth2LoginHelper->exchangeAuthorizationCodeForToken(
                request('code'),
                request('realmId')
            );

            QboToken::updateOrCreate(
                ['realm_id' => request('realmId')],
                [
                    'access_token'             => $accessToken->getAccessToken(),
                    'refresh_token'            => $accessToken->getRefreshToken(),
                    'access_token_expires_at'  => now()->addSeconds($accessToken->getAccessTokenExpiresAt()),
                    'refresh_token_expires_at' => now()->addDays(100),
                ]
            );
            Session::flash('success', 'QuickBooks connected successfully.');
            return redirect()->route('qbo.dashboard');
        } catch (\Throwable $e) {
            Session::flash('warning', 'QuickBooks connection failed. Please reconnect.');
            return redirect()->route('qbo.dashboard');
        }
   }
}
