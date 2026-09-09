<?php

namespace App\Http\Controllers;

use App\Mail\TwoFactorCode;
use App\Models\AuditLog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class TwoFactorController extends Controller
{
    private const CODE_TTL_SECONDS = 600; // 10 minutes

    public function showSecurity()
    {
        $user = auth()->user();

        if (! $user->isStaff()) {
            abort(403, 'Only staff accounts can manage two-factor authentication.');
        }

        return view('settings.security', compact('user'));
    }

    public function showChallenge()
    {
        $pendingUserId = $this->pendingUserId();

        if ($pendingUserId) {
            $user = User::find($pendingUserId);
        } else {
            $user = auth()->user();
        }

        if (! $user) {
            return redirect()->route('login');
        }

        return view('auth.two-factor', compact('user'));
    }

    public function sendCode(Request $request)
    {
        $user = $this->resolveTargetUser($request);

        if (! $user) {
            return redirect()->route('login')->with('error', 'Session expired. Please sign in again.');
        }

        $code = (string) random_int(100000, 999999);

        session([
            'two_factor_code_hash' => Hash::make($code),
            'two_factor_expires_at' => now()->addSeconds(self::CODE_TTL_SECONDS)->timestamp,
        ]);

        Mail::to($user->email)->send(new TwoFactorCode($code, $user->name));

        return back()->with('status', 'A verification code has been sent to your email.');
    }

    public function verify(Request $request)
    {
        $request->validate(['code' => 'required|string|digits:6']);

        $hash = session('two_factor_code_hash');
        $expiresAt = session('two_factor_expires_at');

        if (! $hash || ! $expiresAt || now()->timestamp > $expiresAt) {
            return back()->withErrors(['code' => 'Code expired or not started. Request a new code.']);
        }

        if (! Hash::check(trim($request->code), $hash)) {
            return back()->withErrors(['code' => 'That code is incorrect. Try again.']);
        }

        session(['two_factor_verified_user' => $this->pendingUserId() ?: auth()->id()]);

        // Enrollment flow — turning 2FA on for an authenticated staff member
        if (auth()->check() && session('two_factor_enroll_user') === auth()->id()) {
            $user = auth()->user();
            $user->update([
                'two_factor_enabled' => true,
                'two_factor_enrolled_at' => now(),
            ]);

            AuditLog::log(User::class, $user->id, 'updated', ['two_factor_enabled' => false], ['two_factor_enabled' => true], 'User enabled two-factor authentication');

            session()->forget(['two_factor_enroll_user', 'two_factor_code_hash', 'two_factor_expires_at']);

            return redirect()->route('settings.security')
                ->with('success', 'Two-factor authentication is now enabled. It applies on your next sign-in.');
        }

        // Login flow — complete sign-in
        $userId = $this->pendingUserId();
        if ($userId) {
            $user = User::find($userId);
            if ($user && ! $user->isSuspended()) {
                auth()->login($user, session()->pull('two_factor_remember', false));
                session(['two_factor_verified_user' => $user->id]);

                $routeName = in_array($user->role, ['admin', 'super_admin']) ? 'admin.dashboard'
                    : ($user->role === 'teacher' ? 'teacher.dashboard' : 'parent.dashboard');

                return redirect()->intended(route($routeName));
            }

            return redirect()->route('login')->with('error', 'Verification failed. Please sign in again.');
        }

        // Session challenge for an already-signed-in staff member (e.g. via SSO)
        if (auth()->check()) {
            session()->forget(['two_factor_code_hash', 'two_factor_expires_at']);

            $role = auth()->user()->role;
            $routeName = in_array($role, ['admin', 'super_admin']) ? 'admin.dashboard'
                : ($role === 'school_admin' ? 'school.dashboard' : 'teacher.dashboard');

            return redirect()->intended(route($routeName));
        }

        return redirect()->route('login')->with('error', 'Verification failed. Please sign in again.');
    }

    public function resend(Request $request)
    {
        return $this->sendCode($request);
    }

    public function enable(Request $request)
    {
        $user = $request->user();
        if ($user->two_factor_enabled) {
            return back()->with('info', 'Two-factor authentication is already enabled.');
        }

        $code = (string) random_int(100000, 999999);

        session([
            'two_factor_enroll_user' => $user->id,
            'two_factor_code_hash' => Hash::make($code),
            'two_factor_expires_at' => now()->addSeconds(self::CODE_TTL_SECONDS)->timestamp,
        ]);

        Mail::to($user->email)->send(new TwoFactorCode($code, $user->name));

        return redirect()->route('two-factor.enroll-verify')
            ->with('status', 'A code has been sent to your email. Enter it to confirm.');
    }

    public function disable(Request $request)
    {
        $user = $request->user();
        if (! $user->two_factor_enabled) {
            return back()->with('info', 'Two-factor authentication was already off.');
        }

        $user->update(['two_factor_enabled' => false, 'two_factor_enrolled_at' => null]);

        AuditLog::log(User::class, $user->id, 'updated', ['two_factor_enabled' => true], ['two_factor_enabled' => false], 'User disabled two-factor authentication');

        return back()->with('success', 'Two-factor authentication is now off.');
    }

    public function showEnrollVerify()
    {
        if (! auth()->check() || session('two_factor_enroll_user') !== auth()->id()) {
            return redirect()->route('settings.security');
        }

        return view('auth.two-factor-enroll');
    }

    public function enrollVerify(Request $request)
    {
        $request->validate(['code' => 'required|string|digits:6']);

        $hash = session('two_factor_code_hash');
        $expiresAt = session('two_factor_expires_at');

        if (! $hash || ! $expiresAt || now()->timestamp > $expiresAt) {
            return back()->withErrors(['code' => 'Code expired. Request a new code.']);
        }

        if (! Hash::check(trim($request->code), $hash)) {
            return back()->withErrors(['code' => 'That code is incorrect. Try again.']);
        }

        $user = auth()->user();
        $user->update([
            'two_factor_enabled' => true,
            'two_factor_enrolled_at' => now(),
        ]);

        AuditLog::log(User::class, $user->id, 'updated', ['two_factor_enabled' => false], ['two_factor_enabled' => true], 'User enabled two-factor authentication');

        session()->forget(['two_factor_enroll_user', 'two_factor_code_hash', 'two_factor_expires_at']);

        return redirect()->route('settings.security')
            ->with('success', 'Two-factor authentication is now enabled. It applies on your next sign-in.');
    }

    private function pendingUserId(): ?int
    {
        return session('two_factor_pending_user_id');
    }

    private function resolveTargetUser(Request $request): ?User
    {
        $id = $this->pendingUserId();

        if ($id) {
            return User::find($id);
        }

        return $request->user();
    }
}