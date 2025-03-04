<?php

namespace App\Http\Controllers\Authentication;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Services\RegisterService;
use Illuminate\Support\Facades\Log;

class RegisterController extends Controller
{

    public $registerService;
    public function __construct(RegisterService $registerService)
    {
        $this->registerService = $registerService;
    }

    public function showRegister()
    {
        try {
            return view("auth.register");
        } catch (\Throwable $th) {
            Log::error('Register page load error: ' . $th->getMessage());
            return redirect()->back()->with('error', 'Unable to load registration page.');
        }
    }

    public function register(RegisterRequest $request)
    {
        try {
            $validatedData = $request->validated();

            $user = $this->registerService->createUser($validatedData);

            return redirect()->route('user.home')
                ->with('success', 'Registration successful! Welcome, ' . $user->name);
        } catch (\Throwable $th) {
            Log::error('User registration error: ' . $th->getMessage());
            return redirect()->back()
                ->withInput($request->except('password', 'password_confirmation'))
                ->with('error', 'Registration failed. Please try again.');
        }
    }
}
