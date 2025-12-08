@extends('layouts.app')

@section('content')
<h3>Edit Kategori</h3>

<form method="POST" action="{{ route('admin.categories.update', $category) }}">
    @csrf @method('PUT')

    <div class="mb-3">
        <label>Nama Kategori</label>
        <input type="text" name="name" class="form-control" value="{{ $category->name }}">
    </div>

    <div class="mb-3">
        <label>Deskripsi</label>
        <textarea name="description" class="form-control">{{ $category->description }}</textarea>
    </div>

    <button class="btn btn-primary">Update</button>
</form>
@endsection
