<?php

namespace App\Http\Controllers\Authentication;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\AuthService;

class LoginController extends Controller
{
    public $authService;
    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;

    }

    public function showLogin()
    {
        if ($this->authService->isAuthenticated()) {
            return redirect()->route('home');
        }
        return view("auth.login");
    }

    public function login(LoginRequest $request)
    {

        $credentials = $request->validated();

        $result = $this->authService->attemptLogin($credentials);

        $request ->session()->regenerate();

        return redirect()->intended('user.home')
            ->with('success', 'Welcome back.' . $result['user']->name);
    }

    public function logout(Request $request)
    {

        $this->authService->logout($request);

        return redirect()->route('login')
            ->with('success', 'You have been logged out successfully.');
    }
}
