@extends('layouts.app')
@section('content')
<h3>{{ __('messages.add_user') }}</h3>
<form action="{{ route('admin.users.store') }}" method="POST" class="card p-4">@csrf
    <div class="mb-3"><label>{{ __('messages.name') }}</label><input type="text" name="name" class="form-control" required></div>
    <div class="mb-3"><label>{{ __('messages.email') }}</label><input type="email" name="email" class="form-control" required></div>
    <div class="mb-3"><label>{{ __('messages.password') }}</label><input type="password" name="password" class="form-control" required></div>
    <div class="mb-3"><label>{{ __('messages.role') }}</label>
        <select name="role" class="form-control" required>
            <option value="admin">{{ __('messages.admin') }}</option>
            <option value="relawan">{{ __('messages.volunteer') }}</option>
            <option value="donatur">{{ __('messages.donor') }}</option>
        </select>
    </div>
    <button class="btn btn-primary">{{ __('messages.create') }}</button>
</form>
@endsection
