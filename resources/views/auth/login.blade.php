@extends('layouts.app')

@section('title','Login - Sirkula')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <h3>Login</h3>
        <form method="POST" action="{{ route('login.perform') }}">
            @csrf
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" class="form-control" required autofocus>
            </div>
            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <div class="mb-3 form-check">
                <input type="checkbox" name="remember" class="form-check-input" id="remember">
                <label class="form-check-label" for="remember">Remember me</label>
            </div>
            <button class="btn btn-primary">Login</button>
            <a href="{{ route('register') }}" class="btn btn-primary">Register</a>
        </form>
    </div>
</div>
@endsection
