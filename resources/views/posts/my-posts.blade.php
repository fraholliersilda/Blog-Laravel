@extends('layouts.app')

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <h1>My Blog Posts</h1>
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">All My Posts - {{ auth()->user()->name }}</h3>

                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            @if (session('success'))
                                <div class="alert alert-success">
                                    {{ session('success') }}
                                </div>
                            @endif

                            @if (session('error'))
                                <div class="alert alert-danger">
                                    {{ session('error') }}
                                </div>
                            @endif

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
                                    @foreach ($posts as $key => $row)
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

                                                <a href="{{ route('user.viewPost', ['id' => $row->id]) }}"
                                                    class="btn btn-secondary btn-sm mb-1">View</a>
                                                <br>
                                                @php $postModel = App\Models\Post::find($row->id); @endphp
                                                @can('update-post', $postModel)
                                                    <a href="{{ route('user.editPost', ['id' => $row->id]) }}"
                                                        class="btn btn-success btn-sm mb-1">Edit</a>
                                                @endcan
                                                <br>
                                                @can('delete-post', $postModel)
                                                    <a href="{{ route('user.deletePost', ['id' => $row->id]) }}"
                                                        class="btn btn-danger btn-sm mb-1"
                                                        onclick="return confirm('Are you sure you want to delete this post?')">Delete</a>
                                                @endcan
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

                            @if (count($posts) == 0)
                                <div class="alert alert-info mt-3">
                                    <p>You haven't created any blog posts yet. <a href="{{ route('user.addPost') }}">Create
                                            your first post</a>.</p>
                                </div>
                            @endif
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
