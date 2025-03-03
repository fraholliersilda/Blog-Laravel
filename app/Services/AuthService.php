<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthService
{
    public function attemptLogin(array $credentials, ?int $requiredRoleId = 2)
    {
        if (!Auth::attempt($credentials)) {
            throw ValidationException::withMessages([
                "email" => "These credentials do not match our records.",
            ]);
        }

        $user = Auth::user();

        if ($requiredRoleId !== null && $user->role_id !== $requiredRoleId) {
            Auth::logout();
            $message = $requiredRoleId === 1
                ? 'These credentials do not match our records.'
                : 'These credentials do not match our records.';

            throw ValidationException::withMessages([
                'email' => [$message],
            ]);
        }

        $language = null;
        if ($user->language) {
            $language = $user->language;
            session()->put('applocale', $language);
            app()->setLocale($language);
        }

        return [
            'user' => $user,
            'language' => $language,
        ];
    }

    public function attemptAdminLogin(array $credentials): array
    {
        return $this->attemptLogin($credentials, 1);
    }

    public function logout(Request $request)
    {
        $language = session('applocale');
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        if ($language) {
            session()->put('applocale', $language);
        }

        return $language;
    }

    public function isAuthenticated(?string $guard = null): bool
    {
        return Auth::guard($guard)->check();
    }

}
