<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\EdfricaAuthService;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    protected $authService;

    public function __construct(EdfricaAuthService $authService)
    {
        $this->authService = $authService;
    }

    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
            'terms' => 'accepted',
        ]);

        try {
            $result = $this->authService->register([
                'name' => $request->name,
                'email' => $request->email,
                'password' => $request->password,
                'password_confirmation' => $request->password_confirmation,
                'role' => 'parent',
            ]);

            // Auth server created the user — create local record with edfrica_id
            if (isset($result['user'])) {
                $user = User::create([
                    'edfrica_id' => $result['user']['id'],
                    'name' => $result['user']['name'],
                    'email' => $result['user']['email'],
                    'password' => Hash::make($request->password),
                    'role' => $result['user']['role'] ?? 'parent',
                ]);

                Auth::login($user);

                return redirect()->route('parent.dashboard')->with('success', 'Welcome to TLab!');
            }

            // Auth server rejected the registration — show their error
            $message = 'Registration failed. Please try again.';
            if (isset($result['errors']) && is_array($result['errors'])) {
                $message = collect($result['errors'])->flatten()->first() ?? $message;
            } elseif (isset($result['message'])) {
                $message = $result['message'];
            }

            if (str_contains($message, 'already been taken')) {
                $message = 'This email is already registered. Please sign in instead.';
            }

            return back()->withErrors(['email' => $message])->withInput();
        } catch (ConnectionException $e) {
            // Auth server unreachable — create locally as fallback
            \Illuminate\Support\Facades\Log::warning('Auth server unreachable during registration, falling back to local', [
                'email' => $request->email,
                'error' => $e->getMessage(),
            ]);

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'parent',
            ]);

            Auth::login($user);

            return redirect()->route('parent.dashboard')->with('success', 'Welcome to TLab!');
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Registration error', [
                'email' => $request->email,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return back()->withErrors(['email' => 'Registration failed. Please try again.'])->withInput();
        }
    }
}
