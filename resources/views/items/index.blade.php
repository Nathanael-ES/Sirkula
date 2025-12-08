@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between mb-3">
    <h3>{{ __('messages.item_list') }}</h3>
    <a href="{{ route('items.create') }}" class="btn btn-primary">{{ __('messages.add_item') }}</a>
</div>

<form method="GET" class="row mb-4">
    <div class="col-md-4">
        <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="{{ __('messages.search') }}...">
    </div>

    <div class="col-md-3">
        <select name="category" class="form-control">
            <option value="">{{ __('messages.category') }} - {{ __('messages.filter') }}</option>
            @foreach($categories as $cat)
                <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
            @endforeach
        </select>
    </div>

    <div class="col-md-3">
        <select name="status" class="form-control">
            <option value="">{{ __('messages.status') }} - {{ __('messages.filter') }}</option>
            <option value="pending" {{ request('status')=='pending'?'selected':'' }}>{{ __('messages.pending') }}</option>
            <option value="verified" {{ request('status')=='verified'?'selected':'' }}>{{ __('messages.verified') }}</option>
            <option value="ready" {{ request('status')=='ready'?'selected':'' }}>{{ __('messages.ready') }}</option>
            <option value="distributed" {{ request('status')=='distributed'?'selected':'' }}>{{ __('messages.distributed') }}</option>
        </select>
    </div>

    <div class="col-md-2">
        <button class="btn btn-primary w-100">{{ __('messages.filter') }}</button>
    </div>
</form>

<table class="table table-hover table-bordered">
    <thead class="table-light">
        <tr>
            <th>{{ __('messages.photo') }}</th>
            <th>{{ __('messages.item_name') }}</th>
            <th>{{ __('messages.category') }}</th>
            <th>{{ __('messages.condition') }}</th>
            <th>{{ __('messages.status') }}</th>
            <th width="320">{{ __('messages.action') }}</th>
        </tr>
    </thead>
    <tbody>
    @foreach($items as $item)
        <tr>
            <td class="d-flex align-items-center">
                @if($item->photo)
                    <img src="{{ asset('storage/'.$item->photo) }}" width="70" height="70" class="img-thumbnail me-2" style="cursor:pointer" data-bs-toggle="modal" data-bs-target="#photoModal{{ $item->id }}">
                    <button class="btn btn-sm btn-secondary" data-bs-toggle="modal" data-bs-target="#photoModal{{ $item->id }}">{{ __('messages.view_photo') }}</button>
                @else
                    <span class="text-muted">{{ __('messages.no_data') }}</span>
                @endif
            </td>

            <td>{{ $item->name }}</td>
            <td>{{ $item->category->name ?? '-' }}</td>
            <td>{{ $item->condition }}</td>
            <td>{{ __('messages.' . $item->status) }}</td>

            <td>
                <a href="{{ route('items.edit', $item->id) }}" class="btn btn-sm btn-warning">{{ __('messages.edit') }}</a>

                <form action="{{ route('items.destroy', $item->id) }}" method="POST" class="d-inline">
                    @csrf @method('DELETE')
                    <button class="btn btn-sm btn-danger">{{ __('messages.delete') }}</button>
                </form>

                @if($item->photo)
                    <!-- additional spacing -->
                @endif

                @if(auth()->user()->role === 'admin')
                    @if($item->status === 'pending')
                        <a href="{{ route('items.updateStatus', [$item->id,'verified']) }}" class="btn btn-sm btn-success" onclick="event.preventDefault(); document.getElementById('verify-{{ $item->id }}').submit();">{{ __('messages.verified') }}</a>
                        <form id="verify-{{ $item->id }}" method="POST" action="{{ route('items.updateStatus', [$item->id,'verified']) }}">@csrf @method('PATCH')</form>
                    @endif

                    @if($item->status === 'verified')
                        <a href="{{ route('items.updateStatus', [$item->id,'ready']) }}" class="btn btn-sm btn-primary" onclick="event.preventDefault(); document.getElementById('ready-{{ $item->id }}').submit();">{{ __('messages.ready') }}</a>
                        <form id="ready-{{ $item->id }}" method="POST" action="{{ route('items.updateStatus', [$item->id,'ready']) }}">@csrf @method('PATCH')</form>
                    @endif
                @endif
            </td>
        </tr>
    @endforeach
    </tbody>
</table>

{{ $items->links() }}

@foreach($items as $item)
    @if($item->photo)
    <div class="modal fade" id="photoModal{{ $item->id }}" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-body p-0">
                    <img src="{{ asset('storage/'.$item->photo) }}" class="img-fluid w-100" alt="{{ $item->name }}">
                </div>
            </div>
        </div>
    </div>
    @endif
@endforeach
@endsection
