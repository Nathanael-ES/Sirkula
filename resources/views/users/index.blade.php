@extends('layouts.app')
@section('content')
<div class="d-flex justify-content-between mb-3">
    <h3>{{ __('messages.users') }}</h3>
    <a href="{{ route('admin.users.create') }}" class="btn btn-primary rounded-pill px-3">{{ __('messages.add_user') }}</a>
</div>

<table class="table table-hover">
    <thead><tr><th>#</th><th>{{ __('messages.name') }}</th><th>{{ __('messages.email') }}</th><th>{{ __('messages.role') }}</th><th>{{ __('messages.action') }}</th></tr></thead>
    <tbody>
        @foreach($users as $u)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $u->name }}</td>
            <td>{{ $u->email }}</td>
            <td>{{ __('messages.' . ($u->role == 'donatur' ? 'donor' : ($u->role=='relawan'?'volunteer':'admin'))) }}</td>
            <td>
                <a href="{{ route('admin.users.edit', $u->id) }}" class="btn btn-sm btn-warning bi bi-pencil-square">{{ __('messages.edit') }}</a>
                <form action="{{ route('admin.users.destroy', $u->id) }}" method="POST" class="d-inline">@csrf @method('DELETE')<button class="btn btn-sm btn-danger bi bi-trash">{{ __('messages.delete') }}</button></form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
{{ $users->links() }}
@endsection
