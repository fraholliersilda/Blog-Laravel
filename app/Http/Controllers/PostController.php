<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequest;
use Illuminate\Http\Request;
use App\Models\Media;
use App\Models\Post;
use DB;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function allUserPosts()
    {
        $posts = Post::with(['media', 'author'])
            ->whereHas('media', function ($query) {
                $query->where('user_id', '!=', auth()->id());
            })
            ->get();

        return view('posts.all-user-posts', compact('posts'));
    }

    public function myPosts()
    {
        $user_id = auth()->id();

        $posts = DB::table('posts')
            ->leftJoin('media', function ($join) {
                $join->on('posts.id', '=', 'media.post_id')
                    ->where('media.photo_type', '=', 'cover');
            })
            ->join('users', 'media.user_id', '=', 'users.id')
            ->select('posts.*', 'users.name as author', 'media.path as cover_photo')
            ->where('users.id', $user_id)
            ->get();

        return view('posts.my-posts', compact('posts'));
    }

    public function viewPost($id)
    {
        $post = DB::table('posts')
            ->leftJoin('media', function ($join) {
                $join->on('posts.id', '=', 'media.post_id')
                    ->where('media.photo_type', '=', 'cover');
            })
            ->leftJoin('users', 'media.user_id', '=', 'users.id')
            ->select('posts.*', 'users.name as author', 'media.path as cover_photo')
            ->where('posts.id', $id)
            ->first(); // Remove the user check

        // If no post found, handle the error appropriately
        if (!$post) {
            return redirect()->route('myPosts')->with('error', 'Post not found.');
        }

        return view('posts.view_post', compact('post'));
    }

    public function addPostIndex()
    {
        return view('posts.add_post');
    }

    public function insertPost(PostRequest $request)
    {
        $validatedData = $request->validated();

        $post = new Post();
        $post->title = $validatedData['title'];
        $post->description = $validatedData['description'];
        $post->save();

        if ($request->hasFile('cover_photo')) {
            $file = $request->file('cover_photo');
            $originalName = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();
            $size = $file->getSize();
            $hashName = $file->hashName();

            $path = $file->store('uploads/posts', 'public');

            $media = new Media();
            $media->original_name = $originalName;
            $media->hash_name = $hashName;
            $media->path = $path;
            $media->size = $size;
            $media->extension = $extension;
            $media->photo_type = 'cover';
            $media->user_id = auth()->id();
            $media->post_id = $post->id;
            $media->save();
        }

        return redirect()->route('myPosts')->with('success', 'Post added successfully.');
    }

    public function editPost($id)
    {
        $post = Post::findOrFail($id);

        $this->authorize('update-post', $post);

        $edit = DB::table('posts')
            ->leftJoin('media', function ($join) {
                $join->on('posts.id', '=', 'media.post_id')
                    ->where('media.photo_type', '=', 'cover');
            })
            ->select('posts.*', 'media.path as cover_photo')
            ->where('posts.id', $id)
            ->first();

        return view('posts.edit_post', compact('edit'));
    }


    public function updatePost(PostRequest $request, $id)
    {
        $post = Post::findOrFail($id);

        $this->authorize('update-post', $post);

        $validatedData = $request->validated();


        DB::table('posts')->where('id', $id)->update([
            'title' => $validatedData['title'],
            'description' => $validatedData['description'],
            'updated_at' => now(),
        ]);

        if ($request->hasFile('cover_photo')) {
            $file = $request->file('cover_photo');
            $originalName = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();
            $size = $file->getSize();
            $hashName = $file->hashName();
            $path = $file->store('uploads/posts', 'public');

            $existingMedia = DB::table('media')->where('post_id', $id)->where('photo_type', 'cover')->first();

            if ($existingMedia) {
                Storage::disk('public')->delete($existingMedia->path);

                DB::table('media')->where('id', $existingMedia->id)->update([
                    'original_name' => $originalName,
                    'hash_name' => $hashName,
                    'path' => $path,
                    'size' => $size,
                    'extension' => $extension,
                    'updated_at' => now(),
                ]);
            } else {
                DB::table('media')->insert([
                    'original_name' => $originalName,
                    'hash_name' => $hashName,
                    'path' => $path,
                    'size' => $size,
                    'extension' => $extension,
                    'photo_type' => 'cover',
                    'user_id' => auth()->id(),
                    'post_id' => $id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        return redirect()->route('myPosts')->with('success', 'Post updated successfully.');
    }

    public function deletePost($id)
    {
        $post = Post::findOrFail($id);

        $this->authorize('delete-post', $post);

        $media = DB::table('media')->where('post_id', $id)->get();
        foreach ($media as $item) {
            Storage::disk('public')->delete($item->path);
        }
        DB::table('media')->where('post_id', $id)->delete();

        DB::table('posts')->where('id', $id)->delete();

        return redirect()->route('myPosts')->with('success', 'Post deleted successfully.');
    }
}
