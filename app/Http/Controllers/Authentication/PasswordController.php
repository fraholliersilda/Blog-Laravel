<?php

namespace App\Http\Controllers\Authentication;

use App\Http\Requests\ForgotPasswordRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\PasswordService;
use Illuminate\Support\Facades\Log;

class PasswordController extends Controller
{

    public $passwordService;

    public function __construct(PasswordService $passwordService)
    {
        $this->passwordService = $passwordService;
    }

    public function showForgotPasswordForm()
    {
        try {
            return view('auth.passwords.email');
        } catch (\Throwable $th) {
            Log::error('Forgot password form load error: ' . $th->getMessage());
            return redirect()->back()->with('error', 'Unable to load forgot password form.');
        }
    }

    public function showResetForm(Request $request, $token = null)
    {
        try {
            return view('auth.passwords.reset', ['token' => $token, 'email' => $request->email]);
        } catch (\Throwable $th) {
            Log::error('Password reset form load error: ' . $th->getMessage());
            return redirect()->route('login')->with('error', 'Unable to load password reset form.');
        }
    }

    public function sendResetLink(ForgotPasswordRequest $request)
    {
        try {
            $status = $this->passwordService->sendResetLink($request->only('email'));

            return $this->passwordService->isResetLinkSent($status)
                ? back()->with('status', __($status))
                : back()->withErrors(['email' => __($status)]);
        } catch (\Throwable $th) {
            Log::error('Send reset link error: ' . $th->getMessage());
            return back()->with('error', 'Failed to send password reset link. Please try again.');
        }
    }


    public function resetPassword(ResetPasswordRequest $request)
    {
        try {
            $status = $this->passwordService->resetPassword(
                $request->only('email', 'password', 'password_confirmation', 'token')
            );

            return $this->passwordService->isPasswordReset($status)
                ? redirect()->route('login')->with('status', __($status))
                : back()->withErrors(['email' => __($status)]);
        } catch (\Throwable $th) {
            Log::error('Password reset error: ' . $th->getMessage());
            return back()->with('error', 'Failed to reset password. Please try again.');
        }
    }

}
