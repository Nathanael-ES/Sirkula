@extends('layouts.app')
@section('content')
<h3>{{ __('messages.edit') }} {{ __('messages.category_name') }}</h3>
<form action="{{ route('admin.categories.update', $category->id) }}" method="POST" class="card p-4">@csrf @method('PUT')
    <div class="mb-3"><label>{{ __('messages.category_name') }}</label><input type="text" name="name" class="form-control" value="{{ old('name', $category->name) }}" required></div>
    <button class="btn btn-primary">{{ __('messages.edit') }}</button>
    <a class="btn btn-secondary" href="{{ route('admin.categories.index') }}">{{ __('messages.cancel') }}</a>
</form>
@endsection
