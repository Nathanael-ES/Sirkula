@extends('layouts.app')
@section('content')
<h3>{{ __('messages.edit') }} {{ __('messages.recipient_name') }}</h3>
<form action="{{ route('recipients.update', $recipient->id) }}" method="POST" class="card p-4">@csrf @method('PUT')
    <div class="mb-3"><label>{{ __('messages.recipient_name') }}</label><input type="text" name="name" value="{{ $recipient->name }}" class="form-control" required></div>
    <div class="mb-3"><label>Alamat</label><textarea name="address" class="form-control">{{ $recipient->address }}</textarea></div>
    <div class="mb-3"><label>No HP</label><input type="text" name="phone" value="{{ $recipient->phone }}" class="form-control"></div>
    <button class="btn btn-primary">{{ __('messages.edit') }}</button>
</form>
@endsection
