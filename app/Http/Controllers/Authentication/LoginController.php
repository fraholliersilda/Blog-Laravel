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
            toastr()->error('An error occurred while loading the login page.');
            return redirect()->back();
        }
    }

    public function login(LoginRequest $request)
    {

        try {

            $credentials = $request->validated();

            $result = $this->authService->attemptLogin($credentials);

            $request->session()->regenerate();
            toastr()->success('Welcome back, ' . $result['user']->name);
            return redirect()->intended('home');
        } catch (\Throwable $th) {
            Log::error('Login attempt error: ' . $th->getMessage());
            toastr()->error('Login failed. Please check your credentials and try again.');
            return redirect()->back()->withInput($request->only('email'));
        }
    }

    public function logout(Request $request)
    {
        try {
            $this->authService->logout($request);
            toastr()->success('You have been logged out successfully.');
            return redirect()->route('login');
        } catch (\Throwable $th) {
            Log::error('Logout error: ' . $th->getMessage());
            toastr()->error('An error occurred during logout.');
            return redirect()->route('login');
        }
    }
}
