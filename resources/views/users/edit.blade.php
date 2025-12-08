@extends('layouts.app')
@section('content')
<h3>{{ __('messages.edit') }} {{ __('messages.users') }}</h3>
<form action="{{ route('admin.users.update', $user->id) }}" method="POST" class="card p-4">@csrf @method('PUT')
    <div class="mb-3"><label>{{ __('messages.name') }}</label><input type="text" name="name" class="form-control" value="{{ $user->name }}" required></div>
    <div class="mb-3"><label>{{ __('messages.email') }}</label><input type="email" name="email" class="form-control" value="{{ $user->email }}" required></div>
    <div class="mb-3"><label>{{ __('messages.password') }} ({{ __('messages.cancel') }})</label><input type="password" name="password" class="form-control" placeholder="Kosongkan jika tidak diubah"></div>
    <div class="mb-3"><label>{{ __('messages.role') }}</label>
        <select name="role" class="form-control" required>
            <option value="admin" {{ $user->role=='admin'?'selected':'' }}>{{ __('messages.admin') }}</option>
            <option value="relawan" {{ $user->role=='relawan'?'selected':'' }}>{{ __('messages.volunteer') }}</option>
            <option value="donatur" {{ $user->role=='donatur'?'selected':'' }}>{{ __('messages.donor') }}</option>
        </select>
    </div>
    <button class="btn btn-primary">{{ __('messages.edit') }}</button>
</form>
@endsection
