@extends('layouts.app')
@section('content')
<h3>{{ __('messages.donation_list') }}</h3>

<form class="row mb-3" method="GET">
    <div class="col-md-10"><input class="form-control" name="search" placeholder="{{ __('messages.search') }}" value="{{ request('search') }}"></div>
    <div class="col-md-2"><button class="btn btn-primary w-100 rounded-pill px-3">{{ __('messages.search') }}</button></div>
</form>

<table class="table table-hover">
    <thead><tr><th>{{ __('messages.item_name') }}</th><th>{{ __('messages.donor') }}</th><th>{{ __('messages.action') }}</th></tr></thead>
    <tbody>
        @forelse($donations as $d)
            <tr>
                <td>{{ $d->item->name }}</td>
                <td>{{ $d->donor->name }}</td>
                <td>
                    @if(auth()->user()->role == 'donatur')
                        <form method="POST" action="{{ route('donations.destroy', $d->id) }}">@csrf @method('DELETE')<button class="btn btn-sm btn-danger">{{ __('messages.delete') }}</button></form>
                    @endif
                </td>
            </tr>
        @empty
            <tr><td colspan="3">{{ __('messages.no_data') }}</td></tr>
        @endforelse
    </tbody>
</table>

{{ $donations->links() }}
@endsection
