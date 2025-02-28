@extends('layouts.user_app')

@section('content')
    <div class="container-fluid">
        <h1>{{ __('app.welcome', ['name' => auth()->user()->name]) }}</h1>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title text-center  me-4">
                            {{ __('app.welcome', ['name' => auth()->user()->name]) }}
                            @if (auth()->user()->role->name == 'user')
                                {{ __('app.what_would_you_like_to_do_today') }}
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
                                <p class="mb-2"><span>{{ __('app.want_to_share_your_thoughts') }}</span>
                                    <br><br> <a href="
                                    {{-- {{ route('user.addPost') }} --}}
                                     "
                                        class="btn btn-success btn-lg"><i class="bi bi-pencil-square"></i> {{ __('app.add_new_post') }}</a>
                                </p>
                            </div>

                            <div class="card p-3 shadow-sm">
                                <p class="mb-2"><span>{{ __('app.review_and_manage_posts') }}</span> <br> <br> <a
                                        href="
                                        {{-- {{ route('myPosts') }} --}}
                                         "
                                        class="btn btn-warning btn-lg"><i class="bi bi-eye"></i> {{ __('app.my_posts') }}</a>
                                </p>
                            </div>

                            <div class="card p-3 shadow-sm">
                                <p class="mb-2"><span>{{ __('app.explore_others_posts') }}</span> <br><br>
                                    <a href="
                                    {{-- {{ route('allUserPosts') }} --}}
                                     "
                                        class="btn btn-info btn-lg"><i class="bi bi-search"></i> {{ __('app.view_others_posts') }}</a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
