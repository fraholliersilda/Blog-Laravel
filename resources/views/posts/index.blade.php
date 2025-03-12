@extends('layouts.user_app')
@section('content')
    <div class="container-fluid">
        <h1>My Posts</h1>
        <div class="row">
            @foreach ($posts as $post)
                <div class="col-md-3 mb-4">
                    <div class="card h-100 shadow-sm">
                        @if ($post->media)
                            <img src="{{ asset('storage/' . $post->media->path) }}" alt="Cover Photo"
                                class="card-img-top img-fluid" style="height: 200px; object-fit: cover;">
                        @endif
                        <div class="card-body d-flex flex-column">
                            <h3 class="card-title">{{ $post->title }}</h3>
                            <p class="card-text flex-grow-1">{{ \Str::limit($post->description, 100) }}</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="text-muted">
                                    <i class="bi bi-chat"></i> {{ $post->comments->count() }} Comments
                                </span>
                                <span class="text-muted">{{ $post->created_at->format('M d, Y') }}</span>
                            </div>
                            <div class="mt-auto">
                                <a href="{{ route('posts.show', $post->id) }}" class="btn btn-sm btn-primary mb-2 w-100"><i class="bi bi-eye"></i> Read More</a>
                                <div class="d-flex gap-2">
                                    <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-sm btn-success flex-grow-1"><i
                                            class="bi bi-pencil-square"></i> Edit</a>
                                    <button class="btn btn-sm btn-danger flex-grow-1 delete-post-btn" data-post-id="{{ $post->id }}">
                                        <i class="bi bi-trash"></i> Delete
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
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