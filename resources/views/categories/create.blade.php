@extends('layouts.app')
@section('content')
<h3>{{ __('messages.add_category') }}</h3>
<form action="{{ route('admin.categories.store') }}" method="POST" class="card p-4">@csrf
    <div class="mb-3"><label>{{ __('messages.category_name') }}</label><input type="text" name="name" class="form-control" required></div>
    <button class="btn btn-primary">{{ __('messages.create') }}</button>
    <a class="btn btn-secondary" href="{{ route('admin.categories.index') }}">{{ __('messages.cancel') }}</a>
</form>
@endsection
