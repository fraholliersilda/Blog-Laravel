<div class="comment mb-3 p-2 border rounded {{ $isReply ? 'bg-light ms-3' : '' }}">
    <div class="d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center">
            <div class="me-2">
                @php
                    $profilePicture = $comment->user?->profilePicture?->path ?? null;
                @endphp

                @if ($profilePicture)
                    <img src="{{ asset($profilePicture) }}"
                        alt="{{ $comment->user->name ?? 'Anonymous' }}"
                        class="rounded-circle"
                        style="width: 32px; height: 32px; object-fit: cover;">
                @else
                    <div class="rounded-circle bg-secondary d-flex align-items-center justify-content-center text-white"
                        style="width: 32px; height: 32px;">
                        {{ $comment->user?->name ? substr($comment->user->name, 0, 1) : 'A' }}
                    </div>
                @endif
            </div>
            <p class="fw-bold mb-0">{{ $comment->user->name ?? 'Anonymous' }}</p>
        </div>
        <small class="text-muted">{{ $comment->created_at->diffForHumans() }}</small>
    </div>

    <!-- Comment Body -->
    <div id="comment-body-{{ $comment->id }}" class="ms-4 mt-1">
        <p class="mb-1">{{ $comment->body }}</p>
    </div>

    <!-- Edit Form -->
    <div id="comment-edit-form-{{ $comment->id }}" class="d-none ms-4">
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

    <!-- Action Buttons -->
    <div class="d-flex gap-2 mt-1 ms-4">
        <button class="btn btn-sm btn-outline-primary reply-btn" data-comment-id="{{ $comment->id }}">
            <i class="bi bi-reply"></i> Reply
        </button>

        @if (Auth::id() == $comment->user_id)
            <button class="btn btn-sm btn-outline-success edit-comment-btn" data-comment-id="{{ $comment->id }}">
                <i class="bi bi-pencil"></i> Edit
            </button>
        @endif

        @if (Auth::id() == $comment->user_id || Auth::user()->role_id == 1)
            <form action="{{ route('comments.destroy', $comment->id) }}" method="POST" class="d-inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-sm btn-outline-danger">
                    <i class="bi bi-trash"></i> Delete
                </button>
            </form>
        @endif
    </div>

    <!-- Reply Form -->
    <div class="reply-form mt-2 ms-4 d-none" id="reply-form-{{ $comment->id }}">
        <form action="{{ route('comments.store', ['post' => $comment->post_id]) }}" method="POST">
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

    <!-- Replies Section -->
    @if ($comment->replies->isNotEmpty())
        <div class="replies mt-2 border-start ps-2">
            @foreach ($comment->replies as $reply)
                @include('partials._comment', ['comment' => $reply, 'isReply' => true])
            @endforeach
        </div>
    @endif
</div>
