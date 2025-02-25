@extends('layouts.app')

@section('content')
    <div class="content-wrapper">
        <section class="content">
            <div class="row">
                @foreach ($posts as $post)
                    <div class="col-md-2 mb-3 mt-3 ms-4 p-0">
                        <div class="card h-100">
                            <img src="{{ asset('storage/' . $post->media->first()->path) }}" alt="{{ $post->title }}"
                                class="card-img-top">

                            <div class="card-body">
                                <h5 class="card-title">{{ $post->title }}</h5>
                                <br>
                                <p class="card-text"><em>By: {{ $post->author->name ?? 'Unknown' }}</em></p>
                                <p class="card-text">{{ Str::limit($post->description, 100) }}</p>
                                <div class="buttons" style="display: inline-flex; gap: 10px;">
                                    <a href="{{ route('user.viewPost', $post->id) }}" class="btn btn-secondary">Read
                                        More</a>

                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
    </div>
@endsection
