<?php

namespace App\Services;

use App\Models\Media;
use DB;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;


class MediaService
{
    public function updateProfilePicture(UploadedFile $file)
    {
        return DB::transaction(function () use ($file) {
            $user = Auth::user();

            $this->deleteExistingProfilePicture($user->id);

            $originalName = $file->getClientOriginalName();
            $hashName = $file->hashName();
            $path = $file->storeAs('uploads/profile_pictures', $hashName, 'public');
            $size = $file->getSize();
            $extension = $file->getClientOriginalExtension();


            return Media::create([
                'original_name' => $originalName,
                'hash_name' => $hashName,
                'path' => 'storage/' . $path,
                'size' => $size,
                'extension' => $extension,
                'photo_type' => 'profile_picture',
                'user_id' => $user->id,
            ]);
        });
    }

    private function deleteExistingProfilePicture(int $userId)
    {
        $existingMedia = Media::where('user_id', $userId)
            ->where('photo_type', 'profile_picture')
            ->first();

        if ($existingMedia) {
            Storage::disk('public')->delete('uploads/profile_pictures/' . $existingMedia->hash_name);
            return $existingMedia->delete();
        }
        return true;
    }


    public function getProfilePicture(int $userId)
    {
        return Media::where('user_id', $userId)
            ->where('photo_type', 'profile_picture')
            ->first();
    }

}
