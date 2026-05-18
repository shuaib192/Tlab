<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\EdfricaAuthService;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class LoginController extends Controller
{
    protected $authService;

    public function __construct(EdfricaAuthService $authService)
    {
        $this->authService = $authService;
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $result = $this->authService->login($request->email, $request->password);

        if (isset($result['access_token'])) {
            // Get user profile from Edfrica Identity
            $profile = $this->authService->getUser($result['access_token']);

            if (isset($profile['id'])) {
                // Find or create local user
                $user = User::updateOrCreate(
                    ['edfrica_id' => $profile['id']],
                    [
                        'name' => $profile['name'],
                        'email' => $profile['email'],
                        'password' => Hash::make(Str::random(24)), // Random password, auth is handled by Edfrica
                    ]
                );

                Auth::login($user, $request->has('remember'));

                return redirect()->intended(route('parent.dashboard'));
            }
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records or Edfrica Identity.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
