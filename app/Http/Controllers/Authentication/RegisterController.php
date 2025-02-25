<?php

namespace App\Http\Controllers\Authentication;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\Role;

class RegisterController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function showRegister()
    {
        return view("auth.register");
    }

    public function register(RegisterRequest $request)
    {
        $credentials = $request->validated();
        $role = Role::where('role', 'User')->first();
        if (!$role) {
            return back()->withErrors(['role' => 'The default User role is missing. Contact the admin.']);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $role->id,
        ]);

        Auth::login($user);

        return redirect()->route('home')
            ->with('success', 'Registration successful! Welcome, ' . $user->name);
    }
}
