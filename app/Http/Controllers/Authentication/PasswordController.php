<?php

namespace App\Http\Controllers\Authentication;

use App\Http\Requests\ForgotPasswordRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\PasswordService;

class PasswordController extends Controller
{

    public $passwordService;

    public function __construct(PasswordService $passwordService)
    {
        $this->passwordService = $passwordService;
    }

    public function showForgotPasswordForm()
    {
        return view('auth.passwords.email');
    }

    public function showResetForm(Request $request, $token = null)
    {
        return view('auth.passwords.reset', ['token' => $token, 'email' => $request->email]);
    }

    public function sendResetLink(ForgotPasswordRequest $request)
    {
        $status = $this->passwordService->sendResetLink($request->only('email'));

        return $this ->passwordService->isResetLinkSent($status)
        ? back()->with('status', __($status))
        : back()->withErrors(['email' => __($status)]);
    }


    public function resetPassword(ResetPasswordRequest $request)
    {
        $status = $this->passwordService->resetPassword(
            $request->only('email', 'password', 'password_confirmation', 'token')
        );

        return $this ->passwordService->isPasswordReset($status)
        ? redirect()->route('login')->with('status', __($status))
        : back()->withErrors(['email' => __($status)]);
    }

}
