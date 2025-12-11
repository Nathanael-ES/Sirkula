@extends('layouts.app')
@section('content')
<h3>{{ __('messages.recipient_list') }}</h3>

<form method="GET" class="row mb-3">
    <div class="col-md-10"><input name="search" class="form-control" value="{{ request('search') }}" placeholder="{{ __('messages.search') }}"></div>
    <div class="col-md-2"><button class="btn btn-primary w-100 rounded-pill px-3">{{ __('messages.search') }}</button></div>
</form>

<a href="{{ route('recipients.create') }}" class="btn btn-success mb-3 rounded-pill px-3">{{ __('messages.add_recipient') }}</a>

<table class="table table-hover">
    <thead><tr><th>{{ __('messages.recipient_name') }}</th><th>{{ __('messages.action') }}</th></tr></thead>
    <tbody>
        @forelse($recipients as $r)
            <tr>
                <td>{{ $r->name }}</td>
                <td>
                    <a href="{{ route('recipients.edit', $r->id) }}" class="btn btn-sm btn-warning bi bi-pencil-square">{{ __('messages.edit') }}</a>
                    <form action="{{ route('recipients.destroy', $r->id) }}" method="POST" class="d-inline">@csrf @method('DELETE')<button class="btn btn-sm btn-danger bi bi-trash">{{ __('messages.delete') }}</button></form>
                </td>
            </tr>
        @empty
            <tr><td colspan="2">{{ __('messages.no_data') }}</td></tr>
        @endforelse
    </tbody>
</table>
{{ $recipients->links() }}
@endsection
