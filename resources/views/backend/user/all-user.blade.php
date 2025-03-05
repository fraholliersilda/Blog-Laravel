@extends('layouts.app')
@section('content')
    <section class="content">


        <div class="container-fluid">
            <div class="row">
                <h1>Users Management</h1>
                <div class="col-12">


                    <button type="button" class="btn  btn-primary mb-2" data-bs-toggle="modal" data-target="#addUserModal">
                        Add User
                    </button>


                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">All User</h3>


                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example2" class="table table-bordered table-hover mb-4">
                                <thead>
                                    <tr>
                                        <th>
                                            <a href="{{ request()->fullUrlWithQuery(['column' => 'name', 'direction' => request('direction', 'desc') === 'desc' ? 'asc' : 'desc']) }}" class="text-decoration-none text-dark">
                                                Name
                                                @if(request('column') === 'name')
                                                    @if(request('direction', 'desc') === 'desc')
                                                        <i class="fas fa-sort-down"></i>
                                                    @else
                                                        <i class="fas fa-sort-up"></i>
                                                    @endif
                                                @else
                                                    <i class="fas fa-sort text-muted"></i>
                                                @endif
                                            </a>
                                        </th>
                                        <th>
                                            <a href="{{ request()->fullUrlWithQuery(['column' => 'email', 'direction' => request('direction', 'desc') === 'desc' ? 'asc' : 'desc']) }}" class="text-decoration-none text-dark">
                                                Email
                                                @if(request('column') === 'email')
                                                    @if(request('direction', 'desc') === 'desc')
                                                        <i class="fas fa-sort-down"></i>
                                                    @else
                                                        <i class="fas fa-sort-up"></i>
                                                    @endif
                                                @else
                                                    <i class="fas fa-sort text-muted"></i>
                                                @endif
                                            </a>
                                        </th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>


                                    @foreach ($all as $key => $row)
                                        <tr>
                                            <td>{{ $row->name }}</td>
                                            <td>{{ $row->email }}</td>
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-success btn-sm edit-btn"
                                                    data-bs-toggle="modal" data-target="#editUserModal"
                                                    data-id="{{ $row->id }}" data-name="{{ $row->name }}"
                                                    data-email="{{ $row->email }}" data-role="{{ $row->role_id }}">
                                                    Edit
                                                </button>
                                                <button type="button" class="btn btn-danger btn-sm delete-btn"
                                                    data-bs-toggle="modal" data-target="#deleteUserModal"
                                                    data-id="{{ $row->id }}" data-name="{{ $row->name }}">
                                                    Delete
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach


                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Actions</th>
                                    </tr>
                                </tfoot>
                            </table>
                            {{ $all->links() }}
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>


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

    <!-- Edit User Modal -->
    <div class="modal fade" id="editUserModal" tabindex="-1" role="dialog" aria-labelledby="editUserModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-secondary text-white">
                    <h5 class="modal-title" id="editUserModalLabel">Edit User</h5>
                    <button type="button" class="btn-close text-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <form id="editUserForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="edit_name">Name</label>
                                    <input type="text" class="form-control" id="edit_name" name="name" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="edit_email">Email</label>
                                    <input type="email" class="form-control" id="edit_email" name="email" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Update User</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Delete User Modal -->
    <div class="modal fade" id="deleteUserModal" tabindex="-1" aria-labelledby="deleteUserModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="deleteUserModalLabel">Delete User</h5>
                    <button type="button" class="btn-close text-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete the user: <strong><span id="delete_user_name"></span></strong>?</p>
                    <p class="text-warning">This action cannot be undone.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <form id="deleteUserForm" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function () {
        document.querySelectorAll('.edit-btn').forEach(button => {
            button.addEventListener('click', function () {
                let modal = document.getElementById('editUserModal');
                modal.querySelector('#edit_name').value = this.getAttribute('data-name');
                modal.querySelector('#edit_email').value = this.getAttribute('data-email');
                let form = modal.querySelector('#editUserForm');
                form.action = "/users/update/" + this.getAttribute('data-id');
            });
        });

        document.querySelectorAll('.delete-btn').forEach(button => {
            button.addEventListener('click', function () {
                let modal = document.getElementById('deleteUserModal');
                modal.querySelector('#delete_user_name').textContent = this.getAttribute('data-name');
                let form = modal.querySelector('#deleteUserForm');
                form.action = "/users/delete/" + this.getAttribute('data-id');
            });
        });
    });
</script>
@endpush
