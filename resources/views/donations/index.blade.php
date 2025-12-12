@extends('layouts.app')

@section('content')
<h3>Daftar Donasi</h3>

<form class="row mb-3" method="GET">
    <div class="col-md-10">
        <input class="form-control" name="search" placeholder="Cari barang..." value="{{ request('search') }}">
    </div>
    <div class="col-md-2">
        <button class="btn btn-primary w-100">Cari</button>
    </div>
</form>

<table class="table table-hover">
    <thead>
        <tr>
            <th>Nama Barang</th>
            <th>Kategori</th>
            <th>Donatur</th>
            <th>Status</th>
            @if(auth()->user()->role !== 'donatur')
                <th>Aksi</th>
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
