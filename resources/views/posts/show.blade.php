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

      setupDeleteButtons();

      if (typeof $.fn.dataTable !== 'undefined') {
        $('#posts-table').on('draw.dt', function() {
          setupDeleteButtons();
        });
      }
    });
  </script>