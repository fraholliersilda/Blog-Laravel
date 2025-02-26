<?php

namespace App\Http\Controllers\Authentication;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLogin()
    {
        if (Auth::check()) {
            return redirect()->route('home');
        }
        return view("auth.login");
    }

    public function login(LoginRequest $request)
    {

        $credentials = $request->validated();

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            if ($user->role_id !== 2) {
                Auth::logout();
                throw ValidationException::withMessages([
                    'email' => ['These credentials do not match our records.'],
                ]);
            }

            $request->session()->regenerate();

            return redirect()->intended(route('user.home'))
                ->with('success', 'Welcome back, ' . Auth::user()->name);
        }

        throw ValidationException::withMessages([
            'email' => ['These credentials do not match our records.'],
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')
            ->with('success', 'You have been logged out successfully.');
    }
}
