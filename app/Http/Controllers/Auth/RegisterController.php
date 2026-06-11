<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\EdfricaAuthService;
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
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
        ]);

        // Create user locally FIRST so registration never fails
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'parent',
        ]);

        // Try to sync with auth.edfrica.org (optional — failure doesn't block registration)
        try {
            $result = $this->authService->register([
                'name' => $request->name,
                'email' => $request->email,
                'password' => $request->password,
                'password_confirmation' => $request->password_confirmation,
                'role' => 'parent',
            ]);

            if (isset($result['access_token'])) {
                $profile = $this->authService->getUser($result['access_token']);
                if (isset($profile['id'])) {
                    $user->update([
                        'edfrica_id' => $profile['id'],
                        'password' => Hash::make(Str::random(24)),
                    ]);
                }
            }
        } catch (\Exception $e) {
            // Auth server unavailable — user still registered locally
        }

        Auth::login($user);

        return redirect()->route('parent.dashboard')->with('success', 'Welcome to TLab! Let\'s add your first child.');
    }
}
