@extends(Auth::user()->role_id == 1 ? 'layouts.app' : 'layouts.user_app')
@section('content')
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card shadow-sm">
                    @if ($post->media)
                        <img src="{{ asset('storage/' . $post->media->path) }}" alt="Cover Photo"
                            class="card-img-top img-fluid" style="max-height: 400px; object-fit: cover;">
                    @endif
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <p class="text-muted me-4">By: <em>{{ $post->user->name ?? 'Unknown' }}</em></p>
                            <p class="text-muted">Posted: {{ $post->created_at->format('M d, Y') }}</p>
                        </div>
                        <h1 class="card-title display-5"><b>{{ $post->title }}</b></h1>

                        <div class="card-text mb-4 mt-4">
                            {!! nl2br($post->description) !!}
                        </div>

                        <div class="d-flex justify-content-between mt-4">
                            @if (Auth::id() == $post->user_id || Auth::user()->role_id == 1)
                                <div>
                                    <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-success">
                                        <i class="bi bi-pencil-square"></i> Edit
                                    </a>
                                    <button class="btn btn-danger delete-post-btn" data-post-id="{{ $post->id }}">
                                        <i class="bi bi-trash"></i> Delete
                                    </button>
                                </div>
                            @endif
                            <a href="{{ Auth::user()->role_id == 1 ? route('admin.posts') : (Auth::id() == $post->user_id ? route('posts.myPosts') : route('posts.others')) }}"
                                class="btn btn-secondary">
                                <i class="bi bi-arrow-left"></i> Back to Posts
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Comments Section -->
                @if (auth()->user() && auth()->user()->role_id == 2)
                    <div class="card shadow-sm mt-4">
                        <div class="card-body">
                            <h3 class="card-title mb-3">Comments ({{ $post->comments->count() }})</h3>

                            <div class="mb-3">
                                <form action="{{ route('comments.store', $post->id) }}" method="POST">
                                    @csrf
                                    <div class="d-flex gap-2">
                                        <div>
                                            @if(Auth::user()->profilePicture)
                                                <img src="{{ asset('storage/' . Auth::user()->profilePicture->path) }}"
                                                     alt="{{ Auth::user()->name }}"
                                                     class="rounded-circle"
                                                     style="width: 40px; height: 40px; object-fit: cover;">
                                            @else
                                                <div class="rounded-circle bg-secondary d-flex align-items-center justify-content-center text-white"
                                                     style="width: 40px; height: 40px;">
                                                    {{ substr(Auth::user()->name, 0, 1) }}
                                                </div>
                                            @endif
                                        </div>
                                        <div class="flex-grow-1">
                                            <div class="form-group">
                                                <textarea name="body" rows="2" class="form-control @error('body') is-invalid @enderror"
                                                    placeholder="Add a comment..."></textarea>
                                            </div>
                                            <div class="d-flex justify-content-end mt-2">
                                                <button type="submit" class="btn btn-primary">
                                                    <i class="bi bi-send"></i> Post Comment
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            @forelse($post->comments->whereNull('parent_id') as $comment)
                                @include('partials._comment', ['comment' => $comment, 'isReply' => false])
                            @empty
                                <p>No comments yet. Be the first to comment!</p>
                            @endforelse
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection


<div class="modal fade" id="deletePostModal" tabindex="-1" aria-labelledby="deletePostModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="deletePostModalLabel">Confirm Deletion</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this post? This action cannot be undone.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form id="deletePostForm" action="" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
   document.addEventListener('DOMContentLoaded', function() {
    const setupDeleteButtons = () => {
        const deleteButtons = document.querySelectorAll('.delete-post-btn');
        deleteButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const postId = this.getAttribute('data-post-id');
                const deleteForm = document.getElementById('deletePostForm');
                deleteForm.action = `/posts/${postId}`;
                const deleteModal = new bootstrap.Modal(document.getElementById('deletePostModal'));
                deleteModal.show();
            });
        });
    };

    // Handle reply buttons
    const setupReplyButtons = () => {
        const replyButtons = document.querySelectorAll('.reply-btn');
        replyButtons.forEach(button => {
            button.addEventListener('click', function() {
                const commentId = this.getAttribute('data-comment-id');
                document.getElementById(`reply-form-${commentId}`).classList.remove('d-none');
            });
        });

        const cancelButtons = document.querySelectorAll('.cancel-reply');
        cancelButtons.forEach(button => {
            button.addEventListener('click', function() {
                const commentId = this.getAttribute('data-comment-id');
                document.getElementById(`reply-form-${commentId}`).classList.add('d-none');
            });
        });
    };

    // Handle edit buttons
    const setupEditButtons = () => {
        const editButtons = document.querySelectorAll('.edit-comment-btn');
        editButtons.forEach(button => {
            button.addEventListener('click', function() {
                const commentId = this.getAttribute('data-comment-id');
                document.getElementById(`comment-body-${commentId}`).classList.add('d-none');
                document.getElementById(`comment-edit-form-${commentId}`).classList.remove('d-none');
            });
        });

        const cancelEditButtons = document.querySelectorAll('.cancel-edit');
        cancelEditButtons.forEach(button => {
            button.addEventListener('click', function() {
                const commentId = this.getAttribute('data-comment-id');
                document.getElementById(`comment-body-${commentId}`).classList.remove('d-none');
                document.getElementById(`comment-edit-form-${commentId}`).classList.add('d-none');
            });
        });
    };

    setupDeleteButtons();
    setupReplyButtons();
    setupEditButtons();

    if (typeof $.fn.dataTable !== 'undefined') {
        $('#posts-table').on('draw.dt', function() {
            setupDeleteButtons();
        });
    }
});
</script>
