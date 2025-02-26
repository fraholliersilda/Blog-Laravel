@extends('layouts.app')
@section('content')
    <section class="content">

        <div class="container-fluid">
            <div class="row">
                <h1>Users Management</h1>
                <div class="col-12">


                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">All User</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Serial</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Role</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($all as $key => $row)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $row->name }}</td>
                                            <td>{{ $row->email }}</td>
                                            <td>{{ $row->role_id == 1 ? 'Admin' : ($row->role_id == 2 ? 'User' : 'Unknown') }}
                                            </td>
                                            <td>
                                                <a href="
                                                {{-- {{ route('editUser', ['id' => $row->id]) }} --}}
                                                 "
                                                    class="btn btn-success btn-sm">Edit</a>
                                                <a href="
                                                {{-- {{ route('deleteUser', ['id' => $row->id]) }} --}}
                                                 "
                                                    class="btn btn-danger btn-sm">Delete</a>
                                            </td>
                                        </tr>
                                    @endforeach

                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Serial</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Role</th>
                                        <th>Actions</th>
                                    </tr>
                                </tfoot>
                            </table>
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
@endsection
