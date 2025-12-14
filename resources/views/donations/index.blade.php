@extends('layouts.app')

@section('content')
<h3>{{ __('messages.donation_list') }}</h3>

<form class="row mb-3" method="GET">
    <div class="col-md-10">
        <input class="form-control" name="search" placeholder="{{ __('messages.search') }}" value="{{ request('search') }}">
    </div>
    <div class="col-md-2">
        <button class="btn btn-primary w-100">{{ __('messages.search') }}</button>
    </div>
</form>

<table class="table table-hover">
    <thead>
        <tr>
            <th>{{ __('messages.item_name') }}</th>
            <th>{{ __('messages.category') }}</th>
            <th>{{ __('messages.donor') }}</th>
            <th>{{ __('messages.status') }}</th>
            @if(auth()->user()->role !== 'donatur')
                <th>{{ __('messages.action') }}</th>
            @endif
        </tr>
    </thead>

    <tbody>
        @forelse($donations as $d)
            <tr>
                <td>{{ $d->item->name }}</td>
                <td>{{ $d->item->category->name ?? '-' }}</td>
                <td>{{ $d->donor->name }}</td>
                <td>{{ $d->item->status }}</td>

                @if(auth()->user()->role !== 'donatur')
                <td>
                    <form method="POST" action="{{ route('donations.destroy', $d->id) }}">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-danger">Hapus</button>
                    </form>
                </td>
                @endif
            </tr>
        @empty
            <tr><td colspan="5">Tidak ada data.</td></tr>
        @endforelse
    </tbody>
</table>

{{ $donations->links() }}
@endsection
