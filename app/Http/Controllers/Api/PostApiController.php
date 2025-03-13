<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;
use App\Services\PostService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;
class PostApiController extends Controller
{

    protected PostService $postService;

    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            if ($request->has('my_posts') && $request->my_posts) {
                $posts = Post::with('media')->where('user_id', Auth::id())->paginate(10);
            } else if ($request->has('others_posts') && $request->others_posts) {
                $posts = Post::with('media')->where('user_id', '!=', Auth::id())->paginate(10);
            } else {
                $posts = Post::with('media', 'user')->paginate(10);
            }

            return PostResource::collection($posts);
        } catch (\Throwable $th) {
            Log::error('API - Error fetching posts: ' . $th->getMessage());
            return response()->json([
                'message' => 'Failed to retrive posts',
                'error' => $th->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostRequest $request)
    {
        try {
            $post = $this->postService->createPost($request->validated());
            return new PostResource($post);
        } catch (\Throwable $th) {
            Log::error('API - Error creating post: ' . $th->getMessage());
            return response()->json([
                'message' => 'Failed to create post',
                'error' => $th->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $post = Post::with('media', 'user')->findOrFail($id);
            return new PostResource($post);
        } catch (\Throwable $th) {
            Log::error('API - Error fetching post: ' . $th->getMessage());
            return response()->json([
                'message' => 'Post not found',
                'error' => $th->getMessage()
            ], Response::HTTP_NOT_FOUND);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PostRequest $request, $id)
    {
        try {
            $post = Post::findOrFail($id);

            if ($post->user_id !== Auth::id() && Auth::user()->role_id !== 1) {
                return response()->json([
                    'message' => 'Unauthorized to update this post'
                ], Response::HTTP_FORBIDDEN);
            }

            $this->postService->updatePost($request->validated(), $post);
            return new PostResource($post->fresh(['media']));
        } catch (\Throwable $th) {
            Log::error('API - Error updating post: ' . $th->getMessage());
            return response()->json([
                'message' => 'Failed to update post',
                'error' => $th->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $post = Post::findOrFail($id);

            if ($post->user_id !== Auth::id() && Auth::user()->role_id !== 1) {
                return response()->json([
                    'message' => 'Unauthorized to delete this post'
                ], Response::HTTP_FORBIDDEN);
            }

            $this->postService->deletePost($post);
            return response()->json([
                'message' => 'Post deleted successfully'
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            Log::error('API - Error deleting post: ' . $th->getMessage());
            return response()->json([
                'message' => 'Failed to delete post',
                'error' => $th->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
