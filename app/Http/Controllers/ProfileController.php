<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileRequest;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\UpdatePasswordRequest;
use App\Mail\ProfileDeletedMail;
use Illuminate\Support\Facades\Mail;

class ProfileController extends Controller
{

    public function show()
    {
        return view('profile.show', ['user' => Auth::user()]);
    }

    public function update(ProfileRequest $request)
    {
        $user = Auth::user();

        $user->update($request->validated());

        return redirect()->route('profile.show')->with('success', 'Profile updated successfully.');
    }

    public function updatePassword(UpdatePasswordRequest $request)
    {
        $user = Auth::user();
        if ($request->filled('password')) {
            $user->update([
                'password' => bcrypt($request->password),
            ]);
        }

        return redirect()->route('profile.show')->with('success', 'Password updated successfully.');
    }

    public function delete()
    {
        $user = Auth::user();

        Auth::logout();

        $deleted = $user->forceDelete();

        Mail::to($user->email)->send(new ProfileDeletedMail($user));

        return redirect()->route('login')->with('success', 'Your profile has been deleted.');
    }
}
