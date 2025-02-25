@extends('layouts.app')
@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <h1>Post Management</h1>
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">All Posts</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Serial</th>
                                        <th>Title</th>
                                        <th>Description</th>
                                        <th>Author</th>
                                        <th>Cover Photo</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($all as $key => $row)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $row->title }}</td>
                                            <td>{{ \Illuminate\Support\Str::limit($row->description, 150) }}</td>
                                            <td>{{ $row->author ?? 'Unknown' }}</td>
                                            <td>
                                                @if ($row->cover_photo)
                                                    <img src="{{ asset('storage/' . $row->cover_photo) }}" alt="Cover Photo"
                                                        width="100" height="60" style="object-fit: cover;">
                                                @else
                                                    No Cover Photo
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('viewPost', ['id' => $row->id]) }}"
                                                    class="btn btn-secondary btn-sm mb-1 ">View</a>
                                                <br>
                                                <a href="{{ route('editPost', ['id' => $row->id]) }}"
                                                    class="btn btn-success btn-sm mb-1">Edit</a>
                                                <br>
                                                <a href="{{ route('deletePost', ['id' => $row->id]) }}"
                                                    class="btn btn-danger btn-sm mb-1"
                                                    onclick="return confirm('Are you sure you want to delete this post?')">Delete</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Serial</th>
                                        <th>Title</th>
                                        <th>Description</th>
                                        <th>Author</th>
                                        <th>Cover Photo</th>
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
