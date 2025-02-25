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



                        </div>
                    </div>
                    {{-- Card End --}}
                </div>
                <div class="col-lg-1"></div>
        </section>
    </div>
@endsection
