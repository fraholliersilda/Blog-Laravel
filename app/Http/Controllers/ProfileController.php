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
        try {
            $user = Auth::user();
            $profilePicture = $this->mediaService->getProfilePicture($user->id);

            return view('profile.show', [
                'user' => $user,
                'profilePicture' => $profilePicture
            ]);
        } catch (\Throwable $th) {
            Log::error('Error fetching profile: ' . $th->getMessage());
            return back()->with('error', 'Unable to load profile information.');
        }
    }

    public function update(ProfileRequest $request)
    {
        try {
            toastr()->success('Profile updated successfully.');
            $this->userService->update($request->validated());
            return redirect()->route('profile.show');
        } catch (\Throwable $th) {
            toastr()->error('Failed to update profile. Please try again.');
            Log::error('Profile update error: ' . $th->getMessage());
            return back();
        }
    }

    public function updatePassword(UpdatePasswordRequest $request)
    {
        try {
            toastr()->success('Password updated successfully.');
            $this->userService->updatePassword($request->password);
            return redirect()->route('profile.show');
        } catch (\Throwable $th) {
            toastr()->error('Failed to update password. Please try again.');
            Log::error('Password update error: ' . $th->getMessage());
            return back();
        }
    }

    public function updatePicture(UpdateProfilePictureRequest $request)
    {
        try {
            toastr()->success('Profile Picture updated successfully.');
            $this->mediaService->updateProfilePicture($request->file('profile_picture'));

            return redirect()->route('profile.show');
        } catch (\Throwable $th) {
            toastr()->error('Failed to update profile picture.');
            Log::error('Profile picture update error: ' . $th->getMessage());
            return back();
        }
    }

    public function delete()
    {
        try {
            toastr()->success('Your profile has been deleted.');
            $userInfo = $this->userService->deleteAccount();

            Mail::to($userInfo)->send(new ProfileDeletedMail($userInfo['name']));

            return redirect()->route('login');
        } catch (\Throwable $th) {
            toastr()->error('Failed to delete account. Please try again.');
            Log::error('Account deletion error: ' . $th->getMessage());
            return back();
        }
    }
}
