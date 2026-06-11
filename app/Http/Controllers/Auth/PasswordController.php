<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\EdfricaAuthService;
use Illuminate\Http\Request;

class PasswordController extends Controller
{
    protected $authService;

    public function __construct(EdfricaAuthService $authService)
    {
        $this->authService = $authService;
    }

    public function showForgotForm()
    {
        return view('auth.forgot-password');
    }

    public function sendResetCode(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $result = $this->authService->forgotPassword($request->email);

        return redirect()->route('password.reset')
            ->with('success', 'If an account exists, a 6-digit reset code has been sent to your email.')
            ->with('reset_email', $request->email);
    }

    public function showResetForm()
    {
        return view('auth.reset-password');
    }

    public function reset(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'code' => 'required|string|size:6',
            'password' => 'required|min:8|confirmed',
        ]);

        $result = $this->authService->resetPassword([
            'email' => $request->email,
            'code' => $request->code,
            'password' => $request->password,
            'password_confirmation' => $request->password_confirmation,
        ]);

        if (isset($result['message']) && str_contains(strtolower($result['message']), 'success')) {
            return redirect()->route('login')->with('success', 'Password reset successful! Please log in with your new password.');
        }

        return back()->withErrors(['code' => $result['message'] ?? 'Invalid or expired reset code.'])->withInput();
    }
}
