<?php

namespace App\Http\Controllers\Authentication\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Services\AuthService;
use Illuminate\Http\Request;

class LoginController extends Controller
{

    public $authService;
    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function showLogin()
    {
        if ($this->authService->isAuthenticated('admin')) {
            return redirect()->route('admin.home');
        }
        return view("auth.admin.login");
    }

    public function login(LoginRequest $request)
    {
        $credentials = $request->validated();

        $result = $this->authService->attemptAdminLogin($credentials);

        $request->session()->regenerate();

        return redirect()->intended(route('admin.home'))
            ->with('success', 'Welcome back, ' . $result['user']->name);
    }


    public function logout(Request $request)
    {

        $this->authService->logout($request);

        return redirect()->route('login')
            ->with('success', 'You have been logged out successfully.');
    }
}
