@extends('layouts.app')

@section('content')
    <div class="content-wrapper">
        <section class="content">
            <div class="row">
                <div class="col-lg-1"></div>
                <div class="col-lg-10">

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {{-- Card Start --}}
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">{{ $post->title }}</h5>
                        </div>
                        <div class="card-body">

                            {{-- @can('edit-post', $post->id)
                                <button>Edit</button>
                            @endcan --}}


                            <p><strong>Author:
                                    <br>
                                </strong> {{ $post->author ?? 'Unknown' }}</p>
                            <p><strong>Description:
                                    <br>
                                </strong> {{ $post->description }}</p>
                            @if ($post->cover_photo)
                                <img src="{{ asset('storage/' . $post->cover_photo) }}" alt="Cover Photo" width="300"
                                    height="200" style="object-fit: cover;">
                            @else
                                No Cover Photo
                            @endif

                            @php
                                $postModel = App\Models\Post::find($post->id);
                            @endphp
                            @can('update-post', $postModel)
                                <a href="{{ route('user.editPost', ['id' => $row->id]) }}"
                                    class="btn btn-success btn-sm mb-1">Edit</a>
                            @endcan
                            <br>
                            @can('delete-post', $postModel)
                                <a href="{{ route('user.deletePost', ['id' => $row->id]) }}" class="btn btn-danger btn-sm mb-1"
                                    onclick="return confirm('Are you sure you want to delete this post?')">Delete</a>
                            @endcan

                        </div>
                    </div>
                    {{-- Card End --}}
                </div>
                <div class="col-lg-1"></div>
        </section>
    </div>
@endsection
