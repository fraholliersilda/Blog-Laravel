@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Profile</h1>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <!-- Name and Email Form -->
        <form action="{{ route('profile.update') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $user->name) }}">
                @error('name')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" class="form-control"
                    value="{{ old('email', $user->email) }}">
                @error('email')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <br>
            <button type="submit" class="btn btn-primary">Save Name & Email</button>
        </form>

        <br><br>

        <!-- Password Form -->
        <form action="{{ route('profile.updatePassword') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="password">New Password</label>
                <input type="password" name="password" id="password" class="form-control">
                @error('password')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="password_confirmation">Confirm Password</label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
            </div>

            <br>
            <button type="submit" class="btn btn-primary">Save Password</button>
        </form>

        <br><br>

        <!-- Delete Profile Form -->
        <form action="{{ route('profile.delete') }}" method="POST"
            onsubmit="return confirm('Are you sure you want to delete your profile? This action cannot be undone.')">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">Delete Profile</button>
        </form>
    </div>
@endsection
