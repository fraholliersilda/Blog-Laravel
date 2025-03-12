@extends('layouts.user_app')
@section('content')
    <div class="container-fluid">
        <h1 class="fw-bold text-center my-4">Create New Post</h1>

        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-lg">
                    <div class="card-body">
                        <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="mb-4">
                                <label for="title" class="form-label fs-5">Title:</label>
                                <input type="text" class="form-control" id="title" name="title" required>
                            </div>

                            <div class="mb-4">
                                <label for="description" class="form-label fs-5">Description:</label>
                                <textarea class="form-control" id="description" name="description" rows="12" required></textarea>
                            </div>

                            <div class="mb-4">
                                <label for="cover_photo" class="form-label fs-5">Cover Photo:</label>
                                <input type="file" class="form-control" id="cover_photo" name="cover_photo">
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary btn-lg">Create Post</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
