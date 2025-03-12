<?php
namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Models\Post;
use App\Services\PostService;
use Illuminate\Support\Facades\Auth;
use Log;
use Yajra\DataTables\DataTables;

class PostController extends Controller
{
    protected $postService;

    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store(PostRequest $request)
    {
        try {
            $post = $this->postService->createPost($request->validated());
            toastr()->success('Post created successfully.');
            return redirect()->route('posts.myPosts');
        } catch (\Exception $e) {
            Log::error('Error creating post: ' . $e->getMessage());
            toastr()->error('Failed to create post.');
            return back();
        }
    }

    public function myPosts()
    {
        $posts = Post::with('media')->where('user_id', Auth::id())->get();
        return view('posts.index', compact('posts'));
    }

    public function othersPosts()
    {
        $posts = Post::where('user_id', '!=', Auth::id())->get();
        return view('posts.others_posts', compact('posts'));
    }

    public function edit(Post $post)
    {
        if ($post->user_id !== Auth::id() && Auth::user()->role_id !== 1) {
            abort(403);
        }
        return view('posts.edit', compact('post'));
    }

    public function update(PostRequest $request, Post $post)
    {
        try {
            $this->postService->updatePost($request->validated(), $post);

            toastr()->success('Post updated successfully.');
            return redirect()->back();
        } catch (\Exception $e) {
            Log::error('Error updating post: ' . $e->getMessage());
            toastr()->error('Failed to update post.');
            return back();
        }
    }

    public function destroy(Post $post)
    {
        try {
            $this->postService->deletePost($post);
            toastr()->success('Post deleted successfully.');
            return redirect()->back();
        } catch (\Exception $e) {
            Log::error('Error deleting post: ' . $e->getMessage());
            toastr()->error('Failed to delete post.');
            return back();
        }
    }

    public function adminPosts()
    {
        return view('admin.posts.index');
    }

    public function getPosts()
    {
        try {
            $posts = Post::with('user', 'media')->select('posts.*');

            return DataTables::of($posts)
                ->addColumn('cover_photo', function ($post) {
                    return $post->media ? $post->media->path : null;
                })
                ->addColumn('action', function ($post) {
                    return view('admin.posts.action', ['post' => $post]);
                })
                ->make(true);
        } catch (\Throwable $th) {
            Log::error('Error fetching posts: ' . $th->getMessage());
            return response()->json(['error' => 'Failed to retrieve posts.'], 500);
        }
    }

    public function show(Post $post)
    {
        return view('posts.show', compact('post'));
    }
}
