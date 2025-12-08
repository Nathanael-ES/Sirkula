@extends('layouts.app')
@section('content')
<h3>{{ __('messages.distribution_list') }}</h3>

<form method="GET" class="row mb-3">
    <div class="col-md-10"><input name="search" value="{{ request('search') }}" class="form-control" placeholder="{{ __('messages.search') }}"></div>
    <div class="col-md-2"><button class="btn btn-primary w-100">{{ __('messages.search') }}</button></div>
</form>

<a href="{{ route('distributions.create') }}" class="btn btn-success mb-3">{{ __('messages.add_distribution') }}</a>

<table class="table table-hover">
    <thead><tr><th>{{ __('messages.item_name') }}</th><th>{{ __('messages.recipient_name') }}</th><th>{{ __('messages.distributed_at') }}</th><th>{{ __('messages.volunteer') }}</th><th>{{ __('messages.action') }}</th></tr></thead>
    <tbody>
        @forelse($distributions as $dist)
            <tr>
                <td>{{ $dist->item->name }}</td>
                <td>{{ $dist->recipient->name }}</td>
                <td>{{ \Carbon\Carbon::parse($dist->distributed_at)->format('d M Y H:i') }}</td>
                <td>{{ $dist->volunteer->name ?? '-' }}</td>
                <td>
                    <form action="{{ route('distributions.destroy', $dist->id) }}" method="POST" class="d-inline">@csrf @method('DELETE')<button class="btn btn-sm btn-danger">{{ __('messages.delete') }}</button></form>
                </td>
            </tr>
        @empty
            <tr><td colspan="5">{{ __('messages.no_data') }}</td></tr>
        @endforelse
    </tbody>
</table>
{{ $distributions->links() }}
@endsection
