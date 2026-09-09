<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\TwoFactorCode;
use App\Models\User;
use App\Services\EdfricaAuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

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

        $user = $this->resolveUserOrNull($request->email, $request->password);

        if (! $user) {
            return back()->withErrors([
                'email' => 'The provided credentials do not match our records.',
            ])->onlyInput('email');
        }

        if ($user->isSuspended()) {
            return back()->withErrors([
                'email' => 'This account is suspended. Contact TLab support.',
            ])->onlyInput('email');
        }

        if ($user->requiresTwoFactor()) {
            $code = (string) random_int(100000, 999999);

            session([
                'two_factor_pending_user_id' => $user->id,
                'two_factor_remember' => $request->has('remember'),
                'two_factor_code_hash' => Hash::make($code),
                'two_factor_expires_at' => now()->addSeconds(600)->timestamp,
            ]);

            Mail::to($user->email)->send(new TwoFactorCode($code, $user->name));

            return redirect()->route('two-factor.challenge')
                ->with('status', 'A verification code has been sent to your email.');
        }

        Auth::login($user, $request->has('remember'));

        return redirect()->intended(route($this->homeRedirect($user)));
    }

    protected function resolveUserOrNull(string $email, string $password): ?User
    {
        try {
            $result = $this->authService->login($email, $password);

            if (isset($result['user'])) {
                return User::updateOrCreate(
                    ['edfrica_id' => $result['user']['id']],
                    [
                        'name' => $result['user']['name'],
                        'email' => $result['user']['email'],
                        'password' => Hash::make($password),
                        'role' => $result['user']['role'] ?? 'parent',
                    ]
                );
            }
        } catch (\Exception $e) {
            // Auth server unreachable — fall through to local check
        }

        if (Auth::validate(['email' => $email, 'password' => $password])) {
            return Auth::getProvider()->retrieveByCredentials(['email' => $email]);
        }

        return null;
    }

    protected function homeRedirect(User $user): string
    {
        return $user->homeRoute();
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
