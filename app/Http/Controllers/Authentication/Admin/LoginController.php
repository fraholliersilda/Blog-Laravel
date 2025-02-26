<?php

namespace App\Http\Controllers\Authentication\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest:admin')->except('logout');
    }

    public function showLogin()
    {

        if (Auth::guard('admin')->check()) {
            return redirect()->route('admin.home');
        }
        return view("auth.admin.login");
    }

    public function login(LoginRequest $request)
    {
        $credentials = $request->validated();
        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            if ($user->role_id !== 1) {
                Auth::logout();
                throw ValidationException::withMessages([
                    'email' => ['You do not have administrative privileges.'],
                ]);
            }

            $request->session()->regenerate();

            return redirect()->intended(route('admin.home'))
                ->with('success', 'Welcome back, ' . $user->name);
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
