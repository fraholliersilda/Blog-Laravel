@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <h1>Welcome, {{ auth()->user()->name }}!</h1>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title text-center  me-4">Welcome, {{ auth()->user()->name }}! @if (auth()->user()->role->name == 'user')
                                What would you like to do today?
                            @endif
                        </h5>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-lte-toggle="card-collapse">
                                <i data-lte-icon="expand" class="bi bi-plus-lg"></i>
                                <i data-lte-icon="collapse" class="bi bi-dash-lg"></i>
                            </button>

                            <button type="button" class="btn btn-tool" data-lte-toggle="card-remove">
                                <i class="bi bi-x-lg"></i>
                            </button>
                        </div>
                    </div>

                    <div class="card-footer">


                        <div class="d-grid gap-3">
                            <div class="card p-3 shadow-sm">
                                <p class="mb-2"><span>Want to share your thoughts with the world? </span>
                                    <br><br> <a
                                        href="
                                {{-- {{ route('user.addPost') }} --}}
                                 "
                                        class="btn btn-success btn-lg"><i class="bi bi-pencil-square"></i> Add
                                        New Post</a>
                                </p>
                            </div>

                            <div class="card p-3 shadow-sm">
                                <p class="mb-2"><span>Review and manage your posts?</span> <br> <br> <a
                                        href="
                                {{-- {{ route('myPosts') }} --}}
                                 "
                                        class="btn btn-warning btn-lg"><i class="bi bi-eye"></i> My Posts</a>
                                </p>
                            </div>

                            <div class="card p-3 shadow-sm">
                                <p class="mb-2"><span>Interested in exploring others' posts? </span> <br><br>
                                    <a href="
                                {{-- {{ route('allUserPosts') }} --}}
                                 "
                                        class="btn btn-info btn-lg"><i class="bi bi-search"></i> View Others'
                                        Posts</a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
