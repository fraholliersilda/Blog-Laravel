@extends('layouts.app')
@section('content')
    <main class="app-main">
        <!--begin::App Content Header-->
        <div class="app-content-header">
            <!--begin::Container-->
            <div class="container-fluid">
                <!--begin::Row-->
                <div class="row">
                    <div class="col-sm-6">
                        <h3 class="mb-0">Dashboard</h3>
                    </div>
                </div>
                <!--end::Row-->
            </div>
            <!--end::Container-->
        </div>
        <div class="app-content">
            <!--begin::Container-->
            <div class="container-fluid">
                <!-- Info boxes -->
                {{-- <div class="row">
                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="info-box">
                            <span class="info-box-icon text-bg-primary shadow-sm">
                                <i class="bi bi-gear-fill"></i>
                            </span>
                            <div class="info-box-content">
                                <span class="info-box-text">CPU Traffic</span>
                                <span class="info-box-number">
                                    10
                                    <small>%</small>
                                </span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <!-- /.col -->
                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="info-box">
                            <span class="info-box-icon text-bg-danger shadow-sm">
                                <i class="bi bi-hand-thumbs-up-fill"></i>
                            </span>
                            <div class="info-box-content">
                                <span class="info-box-text">Likes</span>
                                <span class="info-box-number">41,410</span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <!-- /.col -->
                    <!-- <div class="clearfix hidden-md-up"></div> -->
                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="info-box">
                            <span class="info-box-icon text-bg-success shadow-sm">
                                <i class="bi bi-cart-fill"></i>
                            </span>
                            <div class="info-box-content">
                                <span class="info-box-text">Sales</span>
                                <span class="info-box-number">760</span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <!-- /.col -->
                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="info-box">
                            <span class="info-box-icon text-bg-warning shadow-sm">
                                <i class="bi bi-people-fill"></i>
                            </span>
                            <div class="info-box-content">
                                <span class="info-box-text">New Members</span>
                                <span class="info-box-number">2,000</span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </div>
                    <!-- /.col -->
                </div> --}}
                <!-- /.row -->
                <!--begin::Row-->
                <div class="row">
                    <div class="col-md-12">
                        <div class="card mb-4">
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
                                    {{-- <div class="btn-group">
                    <button
                      type="button"
                      class="btn btn-tool dropdown-toggle"
                      data-bs-toggle="dropdown"
                    >
                      <i class="bi bi-wrench"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end" role="menu">
                      <a href="#" class="dropdown-item">Action</a>
                      <a href="#" class="dropdown-item">Another action</a>
                      <a href="#" class="dropdown-item"> Something else here </a>
                      <a class="dropdown-divider"></a>
                      <a href="#" class="dropdown-item">Separated link</a>
                    </div>
                  </div> --}}
                                    <button type="button" class="btn btn-tool" data-lte-toggle="card-remove">
                                        <i class="bi bi-x-lg"></i>
                                    </button>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            {{-- <div class="card-body">
                                Welcome to {{ auth()->user()->role->role ?? 'User' }} - dashboard
                            </div> --}}
                            @if (auth()->user()->role->name == 'user')
                                <div class="card-footer">


                                    <div class="d-grid gap-3">
                                        <div class="card p-3 shadow-sm">
                                            <p class="mb-2"><span>Want to share your thoughts with the world? </span>
                                                <br><br> <a
                                                    href="
                                            {{-- {{ route('user.addPost') }} --}}
                                             "
                                                    class="btn btn-success btn-lg"><i class="bi bi-pencil-square"></i> Add
                                                    New Post</a> </p>
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
                                                    Posts</a></p>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <!-- /.card-footer -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                </div>
            </div>
            <!--end::Container-->
        </div>
        <!--end::App Content-->
    </main>
@endsection
