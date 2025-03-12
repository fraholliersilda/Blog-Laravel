<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Models\Comment;
use App\Models\Post;
use App\Services\CommentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    protected $commentService;
    public function __construct(CommentService $commentService)
    {
        $this->middleware('auth');
        $this->commentService = $commentService;
    }

    public function store(CommentRequest $request, Post $post)
    {
        $comment = $this->commentService->store($request->validated(), $post);
        toastr()->success('Comment added successfully!');
        return redirect()->back();
    }

    public function update(CommentRequest $request, Comment $comment)
    {
        $updated = $this->commentService->update($comment, $request->validated());

        if ($updated) {
            toastr()->success('Comment updated successfully!');
            return redirect()->back();
        }

        toastr()->error('Unauthorized action.');
        return redirect()->back();
    }

    public function destroy(Comment $comment)
    {
        $deleted = $this->commentService->destroy($comment);

        if ($deleted) {
            toastr()->success('Comment deleted successfully!');
            return redirect()->back();
        }

        toastr()->error('Unauthorized action.');
        return redirect()->back();
    }
}