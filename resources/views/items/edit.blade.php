@extends('layouts.app')

@section('content')
<h3>{{ __('messages.edit') }} {{ __('messages.item_name') }}</h3>

<form action="{{ route('items.update', $item->id) }}" method="POST" enctype="multipart/form-data" class="card p-4 shadow-sm">
    @csrf @method('PUT')

    <div class="mb-3">
        <label class="form-label">{{ __('messages.item_name') }}</label>
        <input type="text" name="name" class="form-control" required value="{{ old('name', $item->name) }}">
    </div>

    <div class="mb-3">
        <label class="form-label">{{ __('messages.category') }}</label>
        <select name="category_id" class="form-control" required>
            @foreach($categories as $c)
                <option value="{{ $c->id }}" {{ $item->category_id == $c->id ? 'selected' : '' }}>{{ $c->name }}</option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label class="form-label">{{ __('messages.photo') }}</label>
        <input type="file" name="photo" class="form-control">
        @if($item->photo)
            <div class="mt-2">
                <img src="{{ asset('storage/'.$item->photo) }}" width="120" class="img-thumbnail">
            </div>
        @endif
    </div>

    <div class="mb-3">
        <label class="form-label">{{ __('messages.condition') }}</label>
        <input type="text" name="condition" class="form-control" value="{{ old('condition', $item->condition) }}">
    </div>

    <div class="mb-3">
        <label class="form-label">{{ __('messages.description') }}</label>
        <textarea name="description" class="form-control">{{ old('description', $item->description) }}</textarea>
    </div>
    <button class="btn btn-primary">{{ __('messages.edit') }}</button>
    <br>
    <a href="{{ route('items.index') }}" class="btn btn-secondary">{{ __('messages.cancel') }}</a>
</form>
@endsection
