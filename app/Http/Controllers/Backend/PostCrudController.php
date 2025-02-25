<?php

namespace App\Http\Controllers\backend;
use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequest;
use Illuminate\Http\Request;
use App\Models\Media;
use App\Models\Post;
use DB;
use Illuminate\Support\Facades\Storage;
class PostCrudController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function allPost()
    {

        $all = DB::table('posts')
            ->leftJoin('media', function ($join) {
                $join->on('posts.id', '=', 'media.post_id')
                    ->where('media.photo_type', '=', 'cover');
            })
            ->leftJoin('users', 'media.user_id', '=', 'users.id')
            ->select('posts.*', 'users.name as author', 'media.path as cover_photo')
            ->get();

        return view('backend.post.all-post', compact('all'));
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
            ->first();

        return view('backend.post.view_post', compact('post'));
    }


    public function addPostIndex()
    {
        return view('backend.post.add_post');
    }

    public function insertPost(PostRequest $request)
    {
        // $request->validate([
        //     'title' => 'required|string|max:255',
        //     'description' => 'required|string',
        //     'cover_photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        // ]);
        $validatedData = $request->only(['title', 'description']);

        // $validatedData = $request->only(['title', 'description']);
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


        return redirect()->route('allPost')->with('success', 'Post added successfully.');
    }

    public function editPost($id)
    {
        $edit = DB::table('posts')
            ->leftJoin('media', function ($join) {
                $join->on('posts.id', '=', 'media.post_id')
                    ->where('media.photo_type', '=', 'cover');
            })
            ->select('posts.*', 'media.path as cover_photo')
            ->where('posts.id', $id)
            ->first();

        return view('backend.post.edit_post', compact('edit'));
    }


    public function updatePost(PostRequest $request, $id)
    {
        // $request->validate([
        //     'title' => 'required|string|max:255',
        //     'description' => 'required|string',
        //     'cover_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        // ]);

        $validatedData = $request->validated();

        // Update post
        DB::table('posts')->where('id', $id)->update([
            'title' => $validatedData['title'],
            'description' => $validatedData['description'],
            'updated_at' => now(),
        ]);

        // Handle cover photo update
        if ($request->hasFile('cover_photo')) {
            $file = $request->file('cover_photo');
            $originalName = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();
            $size = $file->getSize();
            $hashName = $file->hashName();
            $path = $file->store('uploads/posts', 'public');

            // Check if the post already has a cover photo
            $existingMedia = DB::table('media')->where('post_id', $id)->where('photo_type', 'cover')->first();

            if ($existingMedia) {
                // Delete old file from storage
                Storage::disk('public')->delete($existingMedia->path);

                // Update existing cover photo
                DB::table('media')->where('id', $existingMedia->id)->update([
                    'original_name' => $originalName,
                    'hash_name' => $hashName,
                    'path' => $path,
                    'size' => $size,
                    'extension' => $extension,
                    'updated_at' => now(),
                ]);
            } else {
                // Insert new cover photo
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

        return redirect()->route('allPost')->with('success', 'Post updated successfully.');
    }

    public function deletePost($id)
    {
        DB::table('posts')->where('id', $id)->delete();
        return redirect()->route('allPost')->with('success', 'Post deleted successfully.');

    }
}
