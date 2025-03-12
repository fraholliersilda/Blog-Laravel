@extends(Auth::user()->role_id == 1 ? 'layouts.app' : 'layouts.user_app')
@section('content')
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card shadow-sm">
                    @if ($post->media)
                        <img src="{{ asset('storage/' . $post->media->path) }}" alt="Cover Photo"
                            class="card-img-top img-fluid" style="max-height: 400px; object-fit: cover;">
                    @endif
                    <div class="card-body">
                        <div class="d-flex justify-content-between ">
                            <p class="text-muted me-4">By: <em>{{ $post->user->name ?? 'Unknown' }}</em></p>
                            <p class="text-muted">Posted: {{ $post->created_at->format('M d, Y') }}</p>
                        </div>
                        <h1 class="card-title display-5"><b>{{ $post->title }}</b></h1>

                        <div class="card-text mb-4 mt-4">
                            {!! nl2br($post->description) !!}
                        </div>

                        <div class="d-flex justify-content-between mt-4">
                            @if (Auth::id() == $post->user_id || Auth::user()->role_id == 1)
                                <div>
                                    <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-success">
                                        <i class="bi bi-pencil-square"></i> Edit
                                    </a>
                                    <form action="{{ route('posts.destroy', $post->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger"
                                            onclick="return confirm('Are you sure you want to delete this post?');">
                                            <i class="bi bi-trash"></i> Delete
                                        </button>
                                    </form>
                                </div>
                            @endif
                            <a href="{{ Auth::user()->role_id == 1 ? route('admin.posts') : (Auth::id() == $post->user_id ? route('posts.myPosts') : route('posts.others')) }}"
                                class="btn btn-secondary">
                                <i class="bi bi-arrow-left"></i> Back to Posts
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
