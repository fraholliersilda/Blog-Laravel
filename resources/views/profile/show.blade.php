@extends(auth()->user()->role_id === 1 ? 'layouts.app' : 'layouts.user_app')

@section('content')
<div class="container py-5 ms-4 ">
    <div class="row ">
        <div class="col-lg-4">
            <div class="card mb-4">
                <div class="card-body text-center">
                    <img src="{{ $profilePicture ? asset($profilePicture->path) : asset('storage/uploads/profile_pictures/default_profile.jpg') }}"
                        alt="Profile Picture" class="rounded-circle img-fluid mb-3" style="width: 150px; height: 150px; object-fit: cover;">
                    <h5 class="mb-1">{{ $user->name }}</h5>
                    <p class="text-muted mb-3">{{ $user->email }}</p>

                    <form action="{{ route('profile.updatePicture') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="profile_picture" class="form-label">Update Profile Picture</label>
                            <input type="file" name="profile_picture" id="profile_picture" class="form-control">
                            @error('profile_picture')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary">Update Picture</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Personal Information</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('profile.update') }}" method="POST">
                        @csrf
                        <div class="row mb-3">
                            <div class="col-sm-3">
                                <label for="name" class="form-label">Name</label>
                            </div>
                            <div class="col-sm-9">
                                <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $user->name) }}">
                                @error('name')
                                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-sm-3">
                                <label for="email" class="form-label">Email</label>
                            </div>
                            <div class="col-sm-9">
                                <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $user->email) }}">
                                @error('email')
                                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="text-end">
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Security</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('profile.updatePassword') }}" method="POST">
                        @csrf
                        <div class="row mb-3">
                            <div class="col-sm-3">
                                <label for="password" class="form-label">New Password</label>
                            </div>
                            <div class="col-sm-9">
                                <input type="password" name="password" id="password" class="form-control">
                                @error('password')
                                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-sm-3">
                                <label for="password_confirmation" class="form-label">Confirm Password</label>
                            </div>
                            <div class="col-sm-9">
                                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
                            </div>
                        </div>

                        <div class="text-end">
                            <button type="submit" class="btn btn-primary">Update Password</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card">
                <div class="card-header bg-danger text-white">
                    <h5 class="mb-0">Delete Account</h5>
                </div>
                <div class="card-body">
                    <p class="text-muted">Once you delete your account, there is no going back. Please be certain.</p>
                    <form action="{{ route('profile.delete') }}" method="POST"
                        onsubmit="return confirm('Are you sure you want to delete your profile? This action cannot be undone.')">
                        @csrf
                        @method('DELETE')
                        <div class="text-end">
                            <button type="submit" class="btn btn-danger">Delete Account</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
