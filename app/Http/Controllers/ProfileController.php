<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileRequest;
use App\Http\Requests\UpdateProfilePictureRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\UpdatePasswordRequest;
use App\Mail\ProfileDeletedMail;
use Illuminate\Support\Facades\Mail;
use App\Models\Media;

class ProfileController extends Controller
{

    public function show()
    {
        $user = Auth::user();
        $profilePicture = $user->media()->where('photo_type', 'profile_picture')->first();

        return view('profile.show', [
            'user' => $user,
            'profilePicture' => $profilePicture
        ]);
    }

    public function update(ProfileRequest $request)
    {
        $user = Auth::user();

        $user->update($request->validated());

        return redirect()->route('profile.show')->with('success', 'Profile updated successfully.');
    }

    public function updatePassword(UpdatePasswordRequest $request)
    {
        $user = Auth::user()->update([
            'password' => bcrypt($request->password),
        ]);

        return redirect()->route('profile.show')->with('success', 'Password updated successfully.');
    }

    public function updatePicture(UpdateProfilePictureRequest $request)
    {
        $user = Auth::user();

        $existingMedia = Media::where('user_id', $user->id)
                            ->where('photo_type', 'profile_picture')
                            ->first();

        if ($existingMedia) {
            Storage::disk('public')->delete('uploads/profile_pictures/' . $existingMedia->hash_name);
            $existingMedia->delete();
        }

        $file = $request->file('profile_picture');
        $originalName = $file->getClientOriginalName();
        $hashName = $file->hashName();
        $path = $file->storeAs('uploads/profile_pictures', $hashName, 'public');
        $size = $file->getSize();
        $extension = $file->getClientOriginalExtension();

        Media::create([
            'original_name' => $originalName,
            'hash_name' => $hashName,
            'path' => 'storage/' . $path,
            'size' => $size,
            'extension' => $extension,
            'photo_type' => 'profile_picture',
            'user_id' => $user->id,
        ]);

        return redirect()->route('profile.show')->with('success', 'Profile Picture updated successfully.');
    }

    public function delete()
    {
        $user = Auth::user();
        $userName = $user->name;
        $userEmail = $user->email;
        Auth::logout();
        $user->forceDelete();

        Mail::to($userEmail)->send(new ProfileDeletedMail($userName));

        return redirect()->route('login')->with('success', 'Your profile has been deleted.');
    }
}
