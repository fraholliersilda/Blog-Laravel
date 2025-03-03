<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class PasswordService
{
    public function sendResetLink(array $data)
    {
        return Password::sendResetLink($data);
    }

    public function resetPassword (array $data)
    {
        return Password::reset(
            $data,
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );
    }

    public function isResetLinkSent(string $status)
    {
        return $status === Password::RESET_LINK_SENT;
    }

    public function isPasswordReset(string $status)
    {
        return $status === Password::PASSWORD_RESET;
    }

}
