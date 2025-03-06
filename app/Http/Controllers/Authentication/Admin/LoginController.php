<?php

namespace App\Http\Controllers\Authentication\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Services\AuthService;
use Illuminate\Http\Request;
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
            if ($this->authService->isAuthenticated('admin')) {
                return redirect()->route('admin.home');
            }
            return view("auth.admin.login");
        } catch (\Throwable $th) {
            Log::error('Admin login page load error: ' . $th->getMessage());
            return redirect()->back()->with('error', 'An error occurred while loading the admin login page.');
        }
    }

    public function login(LoginRequest $request)
    {
        try {
            $credentials = $request->validated();

            $result = $this->authService->attemptAdminLogin($credentials);

            $request->session()->regenerate();
            toastr()->success('Welcome back, ' . $result['user']->name);
            return redirect()->intended(route('admin.home'));
        } catch (\Throwable $th) {
            Log::error('Admin login attempt error: ' . $th->getMessage());
            toastr()->error('Admin login failed. Please check your credentials and try again.');
            return redirect()->back()
                ->withInput($request->only('email'));
        }
    }


    public function logout(Request $request)
    {

        try {
            $this->authService->logout($request);
            toastr()->success('You have been logged out successfully.');
            return redirect()->route('login');
        } catch (\Throwable $th) {
            Log::error('Admin logout error: ' . $th->getMessage());
            toastr()->error('An error occurred during logout.');
            return redirect()->route('login');
        }
    }
}
