@extends('layouts.app')

@section('content')
    <div class="container-fluid py-4">
        <div class="row mb-4">
            <div class="col-md-6">
                <h1 class="display-5 fw-bold text-primary">All Posts Management</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card border-0 shadow">
                    <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center py-3">
                        <h3 class="card-title mb-0 text-primary">All Posts</h3>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="posts-table" class="table table-striped table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th class="fw-bold">ID</th>
                                        <th class="fw-bold">Title</th>
                                        <th class="fw-bold">Description</th>
                                        <th class="fw-bold">Author</th>
                                        <th class="fw-bold">Cover Photo</th>
                                        <th class="fw-bold text-center">Actions</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#posts-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('admin.posts.data') }}',
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'title',
                        name: 'title'
                    },
                    {
                        data: 'description',
                        name: 'description',
                        render: function(data) {
                            return data.length > 50 ? data.substr(0, 50) + '...' : data;
                        }
                    },
                    {
                        data: 'user.name',
                        name: 'user.name'
                    },
                    {
                        data: 'cover_photo',
                        name: 'cover_photo',
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row) {
                            if (data) {
                                return '<img src="{{ asset('storage/') }}/' + data +
                                    '" alt="Cover Photo" class="img-fluid" style="max-height: 60px; object-fit: cover;">';
                            }
                            return 'No photo';
                        }
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ]
            });
        });
    </script>
@endpush

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
                    const deleteModal = new bootstrap.Modal(document.getElementById(
                        'deletePostModal'));
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
