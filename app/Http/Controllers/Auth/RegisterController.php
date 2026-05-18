<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\EdfricaAuthService;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

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
            'name'     => 'required|string|max:255',
            'email'    => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $result = $this->authService->register([
            'name'                  => $request->name,
            'email'                 => $request->email,
            'password'              => $request->password,
            'password_confirmation' => $request->password_confirmation,
        ]);

        // Handle "already have an Edfrica account" per the API docs
        if (isset($result['errors']['email'])) {
            return back()->with('info', 'You already have an Edfrica account! Please log in instead.')->withInput();
        }

        if (isset($result['access_token'])) {
            $profile = $this->authService->getUser($result['access_token']);
            if (isset($profile['id'])) {
                $user = User::updateOrCreate(
                    ['edfrica_id' => $profile['id']],
                    [
                        'name'     => $profile['name'],
                        'email'    => $profile['email'],
                        'password' => Hash::make(Str::random(24)),
                        'role'     => 'parent',
                    ]
                );
                Auth::login($user);
                return redirect()->route('parent.dashboard')->with('success', 'Welcome to TLab! Let\'s add your first child.');
            }
        }

        return back()->withErrors(['email' => 'Registration failed. Please try again.'])->withInput();
    }
}
