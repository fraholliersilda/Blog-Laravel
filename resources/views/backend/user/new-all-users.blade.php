@extends('layouts.app')

@section('content')
    <div class="container-fluid py-4">
        <div class="row mb-4">
            <div class="col-md-6">
                <h1 class="display-5 fw-bold text-primary">Users Management</h1>
            </div>
            <div class="col-md-6 text-md-end">
                <button type="button" class="btn btn-primary btn-lg shadow" data-bs-toggle="modal"
                    data-bs-target="#addUserModal">
                    <i class="bi bi-person-plus"></i> Add New User
                </button>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-light">
                        <h5 class="card-title mb-0">Import Users</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('users.import') }}" method="POST" enctype="multipart/form-data"
                            class="row g-3 align-items-center">
                            @csrf
                            <div class="col-md-8">
                                <div class="input-group">
                                    <input type="file" class="form-control" name="excel_file" id="excel_file" required>
                                    <button type="submit" class="btn btn-success">
                                        <i class="bi bi-upload"></i> Upload
                                    </button>
                                </div>
                                <small class="text-muted">Import users from Excel file</small>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card border-0 shadow">
                    <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center py-3">
                        <h3 class="card-title mb-0 text-primary">All Users</h3>
                        <div class="col-md-11 text-md-end">
                            <button type="button" class="btn btn-success btn-lg shadow"
                                onclick="window.location.href='{{ route('users.export') }}'">
                                <i class="bi bi-file-earmark-spreadsheet"></i> Download Users as Excel
                            </button>
                        </div>

                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="users-table" class="table table-striped table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th class="fw-bold">Name</th>
                                        <th class="fw-bold">Email</th>
                                        <th class="fw-bold text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Data will be loaded by DataTables -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add User Modal -->
    <div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="addUserModalLabel">
                        <i class="bi bi-person-plus"></i> Add New User
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <form action="{{ route('insertUser') }}" method="POST">
                    @csrf
                    <div class="modal-body p-4">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="name" name="name" required
                                        placeholder="Enter name">
                                    <label for="name">Full Name</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating mb-3">
                                    <input type="email" class="form-control" id="email" name="email" required
                                        placeholder="Enter email">
                                    <label for="email">Email Address</label>
                                </div>
                            </div>
                        </div>

                        <div class="form-floating mb-3">
                            <select class="form-select" id="role_id" name="role_id" required>
                                <option value="">Select a role</option>
                                <option value="2">User</option>
                                <option value="1">Admin</option>
                            </select>
                            <label for="role_id">User Role</label>
                        </div>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="form-floating mb-3">
                                    <input type="password" class="form-control" id="password" name="password" required
                                        placeholder="Enter password">
                                    <label for="password">Password</label>
                                    <div class="form-text">Password must be at least 8 characters</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating mb-3">
                                    <input type="password" class="form-control" id="password_confirmation"
                                        name="password_confirmation" required placeholder="Re-enter password">
                                    <label for="password_confirmation">Confirm Password</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer bg-light">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                            <i class="bi bi-x-circle"></i> Cancel
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save"></i> Save User
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
        <script type="text/javascript">
            $(document).ready(function() {
                let table = $('#users-table').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: '{!! route('users.data') !!}',
                    columns: [{
                            data: 'name',
                            name: 'name'
                        },
                        {
                            data: 'email',
                            name: 'email'
                        },
                        {
                            data: 'action',
                            name: 'action',
                            orderable: false,
                            searchable: false,
                            className: 'text-center'
                        }
                    ],
                    drawCallback: function(settings) {
                        $('#user-count').text(settings.json.recordsTotal + ' Users');
                    },
                    language: {
                        processing: '<div class="spinner-border text-primary" role="status"></div>',
                        search: '<i class="bi bi-search"></i> _INPUT_',
                        searchPlaceholder: 'Search users...',
                        lengthMenu: 'Show _MENU_ entries',
                        info: 'Showing _START_ to _END_ of _TOTAL_ users',
                        paginate: {
                            first: '<i class="bi bi-chevron-double-left"></i>',
                            previous: '<i class="bi bi-chevron-left"></i>',
                            next: '<i class="bi bi-chevron-right"></i>',
                            last: '<i class="bi bi-chevron-double-right"></i>'
                        }
                    },
                    dom: '<"row mb-3"<"col-md-6"l><"col-md-6"f>>rt<"row"<"col-md-6"i><"col-md-6"p>>',
                    lengthMenu: [
                        [10, 25, 50, -1],
                        [10, 25, 50, "All"]
                    ]
                });

                // Handle edit user click
                $(document).on('click', '.edit-btn', function() {
                    let id = $(this).data('id');
                    let name = $(this).data('name');
                    let email = $(this).data('email');

                    $('#edit_name').val(name);
                    $('#edit_email').val(email);
                    $('#editUserForm').attr('action', '/update-user/' + id);

                    $('#editUserModal').modal('show');
                });

                // Handle delete user click
                $(document).on('click', '.delete-btn', function() {
                    let id = $(this).data('id');
                    let name = $(this).data('name');

                    $('#delete_user_name').text(name);
                    $('#deleteUserForm').attr('action', '/delete-user/' + id);

                    $('#deleteUserModal').modal('show');
                });
            });
        </script>
    @endpush
@endsection
