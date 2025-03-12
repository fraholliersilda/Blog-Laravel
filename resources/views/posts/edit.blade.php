
@php
    $layout = auth()->user() && auth()->user()->role_id == 2 ? 'layouts.user_app' : 'layouts.app';
@endphp

@extends($layout)

@section('content')
<div class="container-fluid">
    <h1 class="fw-bold text-center my-4">Edit Post</h1>

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-0 rounded-3 shadow-lg mb-4">
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('posts.update', $post->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="title" class="form-label fw-semibold">Title</label>
                            <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title', $post->title) }}" required>
                            @error('title')
                                <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label fw-semibold">Description</label>
                            <textarea id="description" class="form-control @error('description') is-invalid @enderror" name="description" rows="11" required>{{ old('description', $post->description) }}</textarea>
                            @error('description')
                                <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="cover_photo" class="form-label fw-semibold">Cover Photo</label>
                            <input id="cover_photo" type="file" class="form-control @error('cover_photo') is-invalid @enderror" name="cover_photo">
                            @error('cover_photo')
                                <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                            @enderror

                            @if($post->media()->where('photo_type', 'cover')->first())
                                <div class="mt-3">
                                    <p class="fw-semibold mb-1">Current Cover Photo:</p>
                                    <img src="{{ Storage::url($post->media()->where('photo_type', 'cover')->first()->path) }}" class="img-thumbnail" style="max-width: 200px;">
                                </div>
                            @endif
                        </div>

                        <div class="d-flex gap-3 mt-4">
                            <button type="submit" class="btn btn-primary btn-lg fw-bold px-4">Update Post</button>
                            <a href="{{ route('posts.myPosts') }}" class="btn btn-secondary btn-lg fw-bold px-4">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
