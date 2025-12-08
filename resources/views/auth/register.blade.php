@extends('layouts.app')

@section('title','Register - Sirkula')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <h3>Register</h3>
        <form method="POST" action="{{ route('register.perform') }}">
            @csrf
            <div class="mb-3">
                <label class="form-label">Full name</label>
                <input type="text" name="name" value="{{ old('name') }}" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Phone (optional)</label>
                <input type="text" name="phone" value="{{ old('phone') }}" class="form-control">
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Confirm Password</label>
                    <input type="password" name="password_confirmation" class="form-control" required>
                </div>
            </div>

            <button class="btn btn-primary">Register</button>
        </form>
    </div>
</div>
@endsection
