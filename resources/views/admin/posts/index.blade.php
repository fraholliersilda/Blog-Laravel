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
                        <thead class="table-light">>
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
        columns: [
            { data: 'id', name: 'id' },
            { data: 'title', name: 'title' },
            {
                data: 'description',
                name: 'description',
                render: function(data) {
                    return data.length > 50 ? data.substr(0, 50) + '...' : data;
                }
            },
            { data: 'user.name', name: 'user.name' },
            {
                data: 'cover_photo',
                name: 'cover_photo',
                orderable: false,
                searchable: false,
                render: function(data, type, row) {
                    if (data) {
                        return '<img src="{{ asset("storage/") }}/' + data + '" alt="Cover Photo" class="img-fluid" style="max-height: 60px; object-fit: cover;">';
                    }
                    return 'No photo';
                }
            },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ]
    });
});

</script>
@endpush
