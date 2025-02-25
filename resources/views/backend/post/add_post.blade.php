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
                            <h5 class="card-title">Add Post</h5>
                        </div>
                        <div class="card-body">
                            <form role="form" action="{{ route('insertPost') }}" method="post"
                                enctype="multipart/form-data">
                                @csrf

                                {{-- Title --}}
                                <div class="form-group row">
                                    <label for="title" class="col-sm-2 col-form-label"><b>Title</b></label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="title"
                                            placeholder="Enter post title" required>
                                    </div>
                                </div>
                                <br>

                                {{-- Description --}}
                                <div class="form-group row">
                                    <label for="description" class="col-sm-2 col-form-label"><b>Description</b></label>
                                    <div class="col-sm-10">
                                        <textarea class="form-control" name="description" rows="4" placeholder="Enter post description" required></textarea>
                                    </div>
                                </div>
                                <br>

                                {{-- Cover Photo --}}
                                <div class="form-group row">
                                    <label for="cover_photo" class="col-sm-2 col-form-label"><b>Cover Photo</b></label>
                                    <div class="col-sm-10">
                                        <input type="file" class="form-control" name="cover_photo" accept="image/*"
                                            required>
                                    </div>
                                </div>

                        </div>

                        {{-- Submit Button --}}
                        <div class="card-footer">
                            <button type="submit" class="btn btn-info">Submit</button>
                        </div>

                        </form>
                    </div>
                </div>
                {{-- Card End --}}
            </div>
            <div class="col-lg-1"></div>
        </section>
    </div>
@endsection
