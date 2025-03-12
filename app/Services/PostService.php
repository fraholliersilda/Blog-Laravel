<?php
namespace App\Services;

use App\Models\Post;
use App\Models\Media;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PostService
{
    public function createPost($data)
    {
        $post = Post::create([
            'title' => $data['title'],
            'description' => $data['description'],
            'user_id' => Auth::id(),
        ]);

        if (isset($data['cover_photo'])) {
            $this->handleCoverPhoto($data['cover_photo'], $post);
        }

        return $post;
    }

    public function updatePost($data, $post)
    {
        $post->update([
            'title' => $data['title'],
            'description' => $data['description'],
        ]);

        if (isset($data['cover_photo'])) {
            $this->handleCoverPhoto($data['cover_photo'], $post);
        }

        return $post;
    }

    public function deletePost($post)
    {
        Media::where('post_id', $post->id)->delete();
        $post->delete();
    }

    private function handleCoverPhoto($file, $post)
    {
        $path = $file->store('covers', 'public');

        Media::where('post_id', $post->id)->delete();

        Media::create([
            'original_name' => $file->getClientOriginalName(),
            'hash_name' => $file->hashName(),
            'path' => $path,
            'size' => $file->getSize(),
            'extension' => $file->getClientOriginalExtension(),
            'photo_type' => 'cover',
            'user_id' => Auth::id(),
            'post_id' => $post->id,
        ]);
    }
}
