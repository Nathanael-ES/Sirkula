@extends('layouts.app')
@section('content')
<h3>{{ __('messages.add_recipient') }}</h3>
<form action="{{ route('recipients.store') }}" method="POST" class="card p-4">@csrf
    <div class="mb-3"><label>{{ __('messages.recipient_name') }}</label><input type="text" name="name" class="form-control" required></div>
    <div class="mb-3"><label>Alamat</label><textarea name="address" class="form-control"></textarea></div>
    <div class="mb-3"><label>No HP</label><input type="text" name="phone" class="form-control"></div>
    <button class="btn btn-primary">{{ __('messages.create') }}</button>
</form>
@endsection
