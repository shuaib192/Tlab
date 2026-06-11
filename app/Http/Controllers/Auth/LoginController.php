<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\EdfricaAuthService;
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

        // 1. Try local authentication first
        if (Auth::attempt($request->only('email', 'password'), $request->has('remember'))) {
            return redirect()->intended(route('parent.dashboard'));
        }

        // 2. Fallback: try Edfrica auth server for existing Edfrica users
        try {
            $result = $this->authService->login($request->email, $request->password);

            if (isset($result['access_token'])) {
                $profile = $this->authService->getUser($result['access_token']);

                if (isset($profile['id'])) {
                    $user = User::updateOrCreate(
                        ['edfrica_id' => $profile['id']],
                        [
                            'name' => $profile['name'],
                            'email' => $profile['email'],
                            'password' => Hash::make(Str::random(24)),
                        ]
                    );

                    Auth::login($user, $request->has('remember'));

                    return redirect()->intended(route('parent.dashboard'));
                }
            }
        } catch (\Exception $e) {
            // Auth server unavailable — login already handled locally
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
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
