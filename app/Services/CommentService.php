<?php
namespace App\Services;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class CommentService
{
    public function store($data, Post $post)
    {
        $comment = new Comment();
        $comment->body = $data['body'];
        $comment->user_id = Auth::id();
        $comment->post_id = $post->id;
        $comment->parent_id = $data['parent_id'] ?? null;
        $comment->save();

        return $comment;
    }

    public function update(Comment $comment, $data)
    {
        if (Auth::id() == $comment->user_id) {
            $comment->body = $data['body'];
            $comment->save();
            return true;
        }

        return false;
    }

    public function destroy(Comment $comment)
    {
        if (Auth::id() == $comment->user_id) {
            $comment->delete();
            return true;
        }

        return false;
    }
}
