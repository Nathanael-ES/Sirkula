@extends('layouts.app')

@section('content')
<h3>Tambah Kategori</h3>

<form method="POST" action="{{ route('admin.categories.store') }}">
    @csrf
    <div class="mb-3">
        <label>Nama Kategori</label>
        <input type="text" name="name" class="form-control" required>
    </div>

    <div class="mb-3">
        <label>Deskripsi</label>
        <textarea name="description" class="form-control"></textarea>
    </div>

    <button class="btn btn-primary">Simpan</button>
</form>
@endsection
