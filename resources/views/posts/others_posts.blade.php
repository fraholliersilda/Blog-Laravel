@extends('layouts.user_app')
@section('content')
    <div class="container-fluid">
        <h1>All Others' Posts</h1>
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
                            <p class="card-text text-muted">By: <em>{{ $post->user->name ?? 'Unknown' }}</em></p>
                            <p class="card-text flex-grow-1">{{ \Str::limit($post->description, 100) }}</p>
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="text-muted">
                                    <i class="bi bi-chat"></i> {{ $post->comments->count() }} Comments
                                </span>
                                <span class="text-muted">{{ $post->created_at->format('M d, Y') }}</span>
                            </div>
                            <div class="mt-auto">
                                <a href="{{ route('posts.show', $post->id) }}" class="btn btn-sm btn-primary w-100"><i class="bi bi-eye"></i> Read More</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection