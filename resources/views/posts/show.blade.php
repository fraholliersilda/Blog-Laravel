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
                        <div class="d-flex justify-content-between ">
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
                <div class="card shadow-sm mt-4">
                    <div class="card-body">
                        <h3 class="card-title mb-4">Comments ({{ $post->comments->whereNull('parent_id')->count() }})</h3>

                        <!-- Add Comment Form -->
                        <div class="mb-4">
                            <form action="{{ route('comments.store', $post->id) }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <textarea name="body" rows="3" class="form-control @error('body') is-invalid @enderror"
                                        placeholder="Add a comment..."></textarea>
                                    @error('body')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="d-flex justify-content-end mt-2">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="bi bi-send"></i> Post Comment
                                    </button>
                                </div>
                            </form>
                        </div>

                        <!-- Display Comments -->
                        @forelse($post->comments->whereNull('parent_id') as $comment)
                            <div class="comment mb-4 p-3 border rounded">
                                <div class="d-flex justify-content-between">
                                    <p class="fw-bold mb-1">{{ $comment->user->name ?? 'Anonymous' }}</p>
                                    <small class="text-muted">{{ $comment->created_at->diffForHumans() }}</small>
                                </div>
                                <p class="mb-2">{{ $comment->body }}</p>

                                <div class="d-flex gap-2">
                                    <button class="btn btn-sm btn-outline-primary reply-btn"
                                        data-comment-id="{{ $comment->id }}">
                                        <i class="bi bi-reply"></i> Reply
                                    </button>

                                    @if(Auth::id() == $comment->user_id || Auth::user()->role_id == 1)
                                        <form action="{{ route('comments.destroy', $comment->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                <i class="bi bi-trash"></i> Delete
                                            </button>
                                        </form>
                                    @endif
                                </div>

                                <!-- Reply Form (hidden by default) -->
                                <div class="reply-form mt-3 d-none" id="reply-form-{{ $comment->id }}">
                                    <form action="{{ route('comments.store', $post->id) }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="parent_id" value="{{ $comment->id }}">
                                        <div class="form-group">
                                            <textarea name="body" rows="2" class="form-control"
                                                placeholder="Write your reply..." required></textarea>
                                        </div>
                                        <div class="mt-2 d-flex justify-content-end gap-2">
                                            <button type="button" class="btn btn-sm btn-secondary cancel-reply"
                                                data-comment-id="{{ $comment->id }}">Cancel</button>
                                            <button type="submit" class="btn btn-sm btn-primary">Reply</button>
                                        </div>
                                    </form>
                                </div>

                                <!-- Display Replies -->
                                @if($comment->replies && $comment->replies->count() > 0)
                                    <div class="replies mt-3 ms-4 border-start ps-3">
                                        @foreach($comment->replies as $reply)
                                            <div class="reply p-2 mb-2 bg-light rounded">
                                                <div class="d-flex justify-content-between">
                                                    <p class="fw-bold mb-1">{{ $reply->user->name ?? 'Anonymous' }}</p>
                                                    <small class="text-muted">{{ $reply->created_at->diffForHumans() }}</small>
                                                </div>
                                                <p class="mb-2">{{ $reply->body }}</p>

                                                @if(Auth::id() == $reply->user_id || Auth::user()->role_id == 1)
                                                    <form action="{{ route('comments.destroy', $reply->id) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger">
                                                            <i class="bi bi-trash"></i> Delete
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        @empty
                            <div class="alert alert-info">
                                Be the first to comment on this post!
                            </div>
                        @endforelse
                    </div>
                </div>
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

      // Reply functionality
      const replyButtons = document.querySelectorAll('.reply-btn');
      replyButtons.forEach(button => {
        button.addEventListener('click', function() {
          const commentId = this.getAttribute('data-comment-id');
          document.getElementById(`reply-form-${commentId}`).classList.remove('d-none');
        });
      });

      // Cancel reply
      const cancelButtons = document.querySelectorAll('.cancel-reply');
      cancelButtons.forEach(button => {
        button.addEventListener('click', function() {
          const commentId = this.getAttribute('data-comment-id');
          document.getElementById(`reply-form-${commentId}`).classList.add('d-none');
        });
      });

      setupDeleteButtons();

      if (typeof $.fn.dataTable !== 'undefined') {
        $('#posts-table').on('draw.dt', function() {
          setupDeleteButtons();
        });
      }
    });
  </script>