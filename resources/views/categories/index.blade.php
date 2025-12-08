@extends('layouts.app')
@section('content')
<div class="d-flex justify-content-between mb-3">
    <h3>{{ __('messages.categories') }}</h3>
    <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">{{ __('messages.add_category') }}</a>
</div>

<table class="table table-hover">
    <thead><tr><th>#</th><th>{{ __('messages.category_name') }}</th><th>{{ __('messages.action') }}</th></tr></thead>
    <tbody>
        @foreach($categories as $c)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $c->name }}</td>
                <td>
                    <a href="{{ route('admin.categories.edit', $c->id) }}" class="btn btn-sm btn-warning">{{ __('messages.edit') }}</a>
                    <form action="{{ route('admin.categories.destroy', $c->id) }}" method="POST" class="d-inline">@csrf @method('DELETE')<button class="btn btn-sm btn-danger">{{ __('messages.delete') }}</button></form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
{{ $categories->links() }}
@endsection
