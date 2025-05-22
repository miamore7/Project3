@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit Profile</h2>
    <form action="{{ route('profile.update') }}" method="POST">
        @csrf
        @method('PUT') <!-- Ini WAJIB agar Laravel tahu ini request PUT -->

        <div class="mb-3">
            <label class="form-label">Name</label>
            <input type="text" class="form-control" name="name" value="{{ old('name', Auth::user()->name) }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" class="form-control" name="email" value="{{ old('email', Auth::user()->email) }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Password (optional)</label>
            <input type="password" class="form-control" name="password">
        </div>

        <div class="mb-3">
            <label class="form-label">Confirm Password</label>
            <input type="password" class="form-control" name="password_confirmation">
        </div>

        <button type="submit" class="btn btn-success">Save Changes</button>
    </form>
</div>
@endsection
