@extends('layouts.user_app')
@section('content')
    <div class="container-fluid">
        <h1>My Posts</h1>
        <div class="row">
            @foreach ($posts as $post)
                <div class="col-md-3 mb-4">
                    <div class="card h-100 shadow-sm">
                        @if ($post->media)
                            <img src="{{ asset('storage/' . $post->media->path) }}" alt="Cover Photo"
                                class="card-img-top img-fluid" style="height: 200px; object-fit: cover;">
                        @endif
                        <div class="card-body d-flex flex-column">
                            <h3 class="card-title">{{ $post->title }}</h3>
                            <p class="card-text flex-grow-1">{{ \Str::limit($post->description, 100) }}</p>
                            <div class="mt-auto">
                                <a href="{{ route('posts.show', $post->id) }}" class="btn btn-sm btn-primary mb-2 w-100"><i class="bi bi-eye"></i> Read More</a>
                                <div class="d-flex gap-2">
                                    <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-sm btn-success flex-grow-1"><i
                                            class="bi bi-pencil-square"></i> Edit</a>
                                    <form action="{{ route('posts.destroy', $post->id) }}" method="POST" class="flex-grow-1">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger w-100"><i class="bi bi-trash"></i>
                                            Delete</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection