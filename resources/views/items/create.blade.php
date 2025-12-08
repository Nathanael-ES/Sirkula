@extends('layouts.app')

@section('content')
<h3>{{ __('messages.add_item') }}</h3>

<form action="{{ route('items.store') }}" method="POST" enctype="multipart/form-data" class="card p-4 shadow-sm">
    @csrf

    <div class="mb-3">
        <label class="form-label">{{ __('messages.item_name') }}</label>
        <input type="text" name="name" class="form-control" required value="{{ old('name') }}">
    </div>

    <div class="mb-3">
        <label class="form-label">{{ __('messages.category') }}</label>
        <select name="category_id" class="form-control" required>
            <option value="">{{ __('messages.category') }}</option>
            @foreach($categories as $c)
                <option value="{{ $c->id }}">{{ $c->name }}</option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label class="form-label">{{ __('messages.photo') }}</label>
        <input type="file" name="photo" class="form-control">
    </div>

    <div class="mb-3">
        <label class="form-label">{{ __('messages.condition') }}</label>
        <input type="text" name="condition" class="form-control" value="{{ old('condition') }}">
    </div>

    <div class="mb-3">
        <label class="form-label">{{ __('messages.description') }}</label>
        <textarea name="description" class="form-control">{{ old('description') }}</textarea>
    </div>

    <button class="btn btn-primary">{{ __('messages.create') }}</button>
    <a href="{{ route('items.index') }}" class="btn btn-secondary">{{ __('messages.cancel') }}</a>
</form>
@endsection
