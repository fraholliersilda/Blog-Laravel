<?php

namespace App\Http\Controllers\Authentication;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\AuthService;
use Illuminate\Support\Facades\Log;

class LoginController extends Controller
{
    public $authService;
    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;

    }

    public function showLogin()
    {
        try {
            if ($this->authService->isAuthenticated()) {
                return redirect()->route('home');
            }
            return view("auth.login");
        } catch (\Throwable $th) {
            Log::error('Login page load error: ' . $th->getMessage());
            return redirect()->back()->with('error', 'An error occurred while loading the login page.');
        }
    }

    public function login(LoginRequest $request)
    {

        try {
            $credentials = $request->validated();

            $result = $this->authService->attemptLogin($credentials);

            $request->session()->regenerate();

            return redirect()->intended('home')
                ->with('success', 'Welcome back, ' . $result['user']->name);
        } catch (\Throwable $th) {
            Log::error('Login attempt error: ' . $th->getMessage());
            return redirect()->back()
                ->withInput($request->only('email'))
                ->with('error', 'Login failed. Please check your credentials and try again.');
        }
    }

    public function logout(Request $request)
    {
        try {
            $this->authService->logout($request);

            return redirect()->route('login')
                ->with('success', 'You have been logged out successfully.');
        } catch (\Throwable $th) {
            Log::error('Logout error: ' . $th->getMessage());
            return redirect()->route('login')
                ->with('error', 'An error occurred during logout.');
        }
    }
}
