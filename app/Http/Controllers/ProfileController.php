<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileRequest;
use App\Http\Requests\UpdateProfilePictureRequest;
use App\Services\UserService;
use App\Services\MediaService;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\UpdatePasswordRequest;
use App\Mail\ProfileDeletedMail;
use Illuminate\Support\Facades\Mail;
use Log;


class ProfileController extends Controller
{

    public $userService;
    public $mediaService;

    public function __construct(UserService $userService, MediaService $mediaService)
    {
        $this->userService = $userService;
        $this->mediaService = $mediaService;
    }

    public function show()
    {
        $user = Auth::user();
        $profilePicture = $this->mediaService->getProfilePicture($user->id);

        return view('profile.show', [
            'user' => $user,
            'profilePicture' => $profilePicture
        ]);
    }

    public function update(ProfileRequest $request)
    {
        $this->userService->update($request->validated());

        return redirect()->route('profile.show')->with('success', 'Profile updated successfully.');
    }

    public function updatePassword(UpdatePasswordRequest $request)
    {
        $this->userService->updatePassword($request->password);
        return redirect()->route('profile.show')->with('success', 'Password updated successfully.');
    }

    public function updatePicture(UpdateProfilePictureRequest $request)
    {
        try {
            $this->mediaService->updateProfilePicture($request->file('profile_picture'));

            return redirect()->route('profile.show')->with('success', 'Profile Picture updated successfully.');
        } catch (\Throwable $th) {
            //throw $th;
            Log::error($th);
            return back()->with('error', 'Something went wrong.');
        }
    }

    public function delete()
    {
        $userInfo = $this->userService->deleteAccount();

        Mail::to($userInfo)->send(new ProfileDeletedMail($userInfo['name']));

        return redirect()->route('login')->with('success', 'Your profile has been deleted.');
    }
}
