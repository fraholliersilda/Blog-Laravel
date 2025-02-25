@extends('layouts.app')
@section('content')
    <div class="content-wrapper">
        <section class="content">
            <div class="row">
                <div class="col-lg-1">

                </div>
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

                    {{-- card start --}}
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">
                                Add User
                            </h5>
                        </div>
                        <div class="card-body">
                            <form role="form" action="{{ route('insertUser') }}" method="post">
                                @csrf
                                <div class="form-group row">
                                    <label for="name"class="col-sm-2 col-form-label"><b> User name</b> </label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="name"
                                            placeholder="Enter your name" required>
                                    </div>
                                </div>
                                <br>
                                <div class="form-group row">
                                    <label for="email"class="col-sm-2 col-form-label"> <b>User email</b> </label>
                                    <div class="col-sm-10">
                                        <input type="email" class="form-control" name="email"
                                            placeholder="Enter Email Address" required>
                                    </div>
                                </div>
                                <br>
                                <div class="form-group row">
                                    <label for="password" class="col-sm-2 col-form-label"> <b>Password</b> </label>
                                    <div class="col-sm-10">
                                        <input type="password" class="form-control" name="password"
                                            placeholder="Enter password" required>
                                    </div>
                                </div>
                                <br>
                                <div class="form-group row">
                                    <label for="exampleFormControlSelect1" class="col-sm-2 col-form-label"><b>User Role</b>
                                    </label>
                                    <div class="col-sm-10">
                                        <select class="form-control" name="role_id" id="exampleFormControlSelect1" required>
                                            <option value="2">User</option>
                                            <option value="1">Admin</option>
                                        </select>
                                    </div>
                                </div>


                        </div>

                        <div class="card-footer">
                            <button type="submit" class="btn btn-info">Submit</button>

                        </div>


                        </form>
                    </div>
                </div>
                {{-- card end --}}
            </div>
            <div class="col-lg-1">

            </div>

    </div>
    </section>
    </div>
@endsection
