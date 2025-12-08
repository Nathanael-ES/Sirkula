@extends('layouts.app')
@section('content')
<h3>{{ __('messages.add_distribution') }}</h3>
<form action="{{ route('distributions.store') }}" method="POST" class="card p-4">@csrf
    <div class="mb-3">
        <label>{{ __('messages.item_name') }}</label>
        <select name="item_id" class="form-control" required>
            <option value="">{{ __('messages.item_name') }}</option>
            @foreach($items as $it)
                <option value="{{ $it->id }}">{{ $it->name }} ({{ $it->condition }})</option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label>{{ __('messages.recipient_name') }}</label>
        <select name="recipient_id" class="form-control" required>
            <option value="">{{ __('messages.recipient_name') }}</option>
            @foreach($recipients as $r)
                <option value="{{ $r->id }}">{{ $r->name }}</option>
            @endforeach
        </select>
    </div>

    <button class="btn btn-primary">{{ __('messages.create') }}</button>
</form>
@endsection
