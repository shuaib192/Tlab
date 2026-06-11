<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\EdfricaAuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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

        try {
            // 1. Try auth server first (central identity source)
            $result = $this->authService->login($request->email, $request->password);

            if (isset($result['user'])) {
                // Create or update local record from auth server data
                $user = User::updateOrCreate(
                    ['edfrica_id' => $result['user']['id']],
                    [
                        'name' => $result['user']['name'],
                        'email' => $result['user']['email'],
                        'password' => Hash::make($request->password),
                        'role' => $result['user']['role'] ?? 'parent',
                    ]
                );

                Auth::login($user, $request->has('remember'));

                return redirect()->intended(route('parent.dashboard'));
            }

            // Auth server said invalid credentials
            if (isset($result['message'])) {
                // Fallback: try local credentials in case auth server DB is out of sync
                if (Auth::attempt($request->only('email', 'password'), $request->has('remember'))) {
                    return redirect()->intended(route('parent.dashboard'));
                }

                return back()->withErrors([
                    'email' => 'The provided credentials do not match our records.',
                ])->onlyInput('email');
            }
        } catch (\Exception $e) {
            // Auth server unreachable — fall back to local credentials
            if (Auth::attempt($request->only('email', 'password'), $request->has('remember'))) {
                return redirect()->intended(route('parent.dashboard'));
            }
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
