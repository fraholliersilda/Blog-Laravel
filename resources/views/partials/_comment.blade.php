<div class="comment mb-3 p-2 border rounded {{ $isReply ? 'bg-light ms-3' : '' }}">
    <div class="d-flex justify-content-between align-items-center">
        <p class="fw-bold mb-0">{{ $comment->user->name ?? 'Anonymous' }}</p>
        <small class="text-muted">{{ $comment->created_at->diffForHumans() }}</small>
    </div>

    <div id="comment-body-{{ $comment->id }}">
        <p class="mb-1 mt-1">{{ $comment->body }}</p>
    </div>

    <div id="comment-edit-form-{{ $comment->id }}" class="d-none">
        <form action="{{ route('comments.update', $comment->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <textarea name="body" rows="2" class="form-control">{{ $comment->body }}</textarea>
            </div>
            <div class="mt-2 d-flex justify-content-end gap-2">
                <button type="button" class="btn btn-sm btn-secondary cancel-edit"
                    data-comment-id="{{ $comment->id }}">Cancel</button>
                <button type="submit" class="btn btn-sm btn-success">Save</button>
            </div>
        </form>
    </div>

    <div class="d-flex gap-2 mt-1">
        <button class="btn btn-sm btn-outline-primary reply-btn" data-comment-id="{{ $comment->id }}">
            <i class="bi bi-reply"></i> Reply
        </button>

        @if (Auth::id() == $comment->user_id)
            <button class="btn btn-sm btn-outline-success edit-comment-btn" data-comment-id="{{ $comment->id }}">
                <i class="bi bi-pencil"></i> Edit
            </button>
        @endif

        @if (Auth::id() == $comment->user_id || Auth::user()->role_id == 1)
            <form action="{{ route('comments.destroy', $comment->id) }}" method="POST" class="d-inline" style="margin-block-end: 0px;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-sm btn-outline-danger">
                    <i class="bi bi-trash"></i> Delete
                </button>
            </form>
        @endif
    </div>

    <div class="reply-form mt-2 d-none" id="reply-form-{{ $comment->id }}">
        <form action="{{ route('comments.store', $comment->post_id) }}" method="POST">
            @csrf
            <input type="hidden" name="parent_id" value="{{ $comment->id }}">
            <div class="form-group">
                <textarea name="body" rows="2" class="form-control" placeholder="Write your reply..." required></textarea>
            </div>
            <div class="mt-2 d-flex justify-content-end gap-2">
                <button type="button" class="btn btn-sm btn-secondary cancel-reply"
                    data-comment-id="{{ $comment->id }}">Cancel</button>
                <button type="submit" class="btn btn-sm btn-primary">Reply</button>
            </div>
        </form>
    </div>

    <!-- Replies -->
    @if ($comment->replies && $comment->replies->count() > 0)
        <div class="replies mt-2 border-start ps-2">
            @foreach ($comment->replies as $reply)
                @include('partials._comment', ['comment' => $reply, 'isReply' => true])
            @endforeach
        </div>
    @endif
</div>