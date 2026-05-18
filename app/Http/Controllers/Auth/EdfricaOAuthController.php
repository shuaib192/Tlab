<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class EdfricaOAuthController extends Controller
{
    private function authUrl(): string
    {
        return rtrim(config('services.edfrica.auth_url', env('EDFRICA_AUTH_URL')), '/');
    }

    /**
     * Redirect the user to Edfrica OAuth authorization page.
     */
    public function redirect()
    {
        $state = Str::random(40);
        session(['oauth_state' => $state]);

        $query = http_build_query([
            'client_id'     => env('EDFRICA_CLIENT_ID'),
            'redirect_uri'  => route('auth.edfrica.callback'),
            'response_type' => 'code',
            'scope'         => 'openid profile email',
            'state'         => $state,
        ]);

        return redirect($this->authUrl() . '/oauth/authorize?' . $query);
    }

    /**
     * Handle the OAuth callback from Edfrica.
     */
    public function callback(Request $request)
    {
        // CSRF state check
        if ($request->state !== session('oauth_state')) {
            return redirect()->route('login')->with('error', 'Invalid OAuth state. Please try again.');
        }

        if ($request->has('error')) {
            return redirect()->route('login')->with('error', 'Edfrica login was denied: ' . $request->error_description);
        }

        // Exchange code for access token
        $tokenResponse = Http::asForm()->post($this->authUrl() . '/oauth/token', [
            'grant_type'    => 'authorization_code',
            'client_id'     => env('EDFRICA_CLIENT_ID'),
            'client_secret' => env('EDFRICA_CLIENT_SECRET'),
            'redirect_uri'  => route('auth.edfrica.callback'),
            'code'          => $request->code,
        ]);

        if (!$tokenResponse->successful()) {
            return redirect()->route('login')->with('error', 'Could not connect to Edfrica. Please try again.');
        }

        $token = $tokenResponse->json('access_token');

        // Fetch user info from Edfrica
        $userResponse = Http::withToken($token)->get($this->authUrl() . '/api/user');

        if (!$userResponse->successful()) {
            return redirect()->route('login')->with('error', 'Could not fetch your Edfrica profile.');
        }

        $edfrica = $userResponse->json();

        // Create or update local user record
        $user = User::updateOrCreate(
            ['edfrica_id' => $edfrica['id']],
            [
                'name'       => $edfrica['name'],
                'email'      => $edfrica['email'],
                'role'       => $edfrica['role'] ?? 'parent',
                'password'   => bcrypt(Str::random(32)), // SSO users don't use local passwords
            ]
        );

        Auth::login($user, true);

        return redirect()->intended(route('parent.dashboard'));
    }
}
