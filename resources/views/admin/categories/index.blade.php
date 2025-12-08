@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between">
    <h3>Kategori Barang</h3>
    <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">Tambah Kategori</a>
</div>

<table class="table mt-3">
    <thead>
        <tr>
            <th>Nama</th>
            <th>Deskripsi</th>
            <th width="150"></th>
        </tr>
    </thead>
    <tbody>
    @foreach($categories as $cat)
        <tr>
            <td>{{ $cat->name }}</td>
            <td>{{ $cat->description }}</td>
            <td>
                <a href="{{ route('admin.categories.edit',$cat) }}" class="btn btn-sm btn-warning">Edit</a>
                <form action="{{ route('admin.categories.destroy',$cat) }}" method="POST" class="d-inline">
                    @csrf @method('DELETE')
                    <button class="btn btn-sm btn-danger">Hapus</button>
                </form>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>

{{ $categories->links() }}
@endsection
