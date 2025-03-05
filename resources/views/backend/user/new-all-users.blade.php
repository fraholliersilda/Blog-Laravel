@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header ">
            <h3 class="card-title align-self-center">Users List</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-lg btn-primary mb-2" data-bs-toggle="modal" data-target="#addUserModal">
                    Add User
                </button>
            </div>
        </div>
        <div class="card-body">
            {{ $dataTable->table() }}
        </div>
    </div>
</div>



    <!-- Add User Modal -->
    <div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-secondary text-white">
                    <h5 class="modal-title" id="addUserModalLabel">Add New User</h5>
                    <button type="button" class="btn-close text-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('insertUser') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" class="form-control" id="name" name="name" required
                                        placeholder="Enter name">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" required
                                        placeholder="Enter email">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="role_id">Role</label>
                            <select class="form-control" id="role_id" name="role_id" required>
                                <option value="">Select Role</option>
                                <option value="2">User</option>
                                <option value="1">Admin</option>
                            </select>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input type="password" class="form-control" id="password" name="password" required
                                        placeholder="Enter password">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="password_confirmation">Confirm Password</label>
                                    <input type="password" class="form-control" id="password_confirmation"
                                        name="password_confirmation" required placeholder="Re-enter password">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save User</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
    <script type="text/javascript">
        
        $(document).ready(function () {
            let table = $('#users-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{!! route('users.index') !!}',
                columns: [
                    { data: 'name', name: 'name' },
                    { data: 'email', name: 'email' },
                    { data: 'action', name: 'action', orderable: false, searchable: false }
                ]
            });

            $(document).on('click', '.edit-btn', function () {
                let id = $(this).data('id');
                let name = $(this).data('name');
                let email = $(this).data('email');

                $('#edit_name').val(name);
                $('#edit_email').val(email);
                $('#editUserForm').attr('action', '/update-user/' + id);

                $('#editUserModal').modal('show');
            });

            $(document).on('click', '.delete-btn', function () {
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
