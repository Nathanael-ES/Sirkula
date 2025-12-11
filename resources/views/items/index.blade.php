
@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-between mb-3">
    <h3 class="fw-bold">Katalog Barang</h3>
    <a href="{{ route('items.create') }}" class="btn btn-primary rounded-pill px-3">
        + Tambah Barang
    </a>
</div>

{{-- FILTER --}}
<form method="GET" class="row mb-4">

    <div class="col-md-4">
        <input type="text" name="search" value="{{ request('search') }}"
            class="form-control" placeholder="Cari nama barang...">
    </div>

    <div class="col-md-3">
        <select name="category" class="form-control">
            <option value="">Semua Kategori</option>
            @foreach($categories as $cat)
            <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>
                {{ $cat->name }}
            </option>
            @endforeach
        </select>
    </div>

    <div class="col-md-3">
        <select name="status" class="form-control">
            <option value="">Semua Status</option>
            <option value="pending" {{ request('status')=='pending'?'selected':'' }}>Pending</option>
            <option value="verified" {{ request('status')=='verified'?'selected':'' }}>Terverifikasi</option>
            <option value="ready" {{ request('status')=='ready'?'selected':'' }}>Siap Distribusi</option>
            <option value="distributed" {{ request('status')=='distributed'?'selected':'' }}>Terdistribusi</option>
        </select>
    </div>

    <div class="col-md-2">
        <button class="btn btn-primary w-100 rounded-pill">Filter</button>
    </div>

</form>

{{-- KATALOG --}}
<div class="row g-4">

    @foreach($items as $item)
    <div class="col-md-4 col-lg-3">

        <div class="glass-card mb-4 p-0">

            {{-- FOTO --}}
            @if($item->photo)
                <img src="{{ $item->photo ? asset('storage/'.$item->photo) : 'https://via.placeholder.com/400x300?text=No+Photo' }}"
                    class="glass-img">
            @else
                <div class="d-flex justify-content-center align-items-center bg-light"
                     style="height:200px;">
                    <span class="text-muted">Tidak ada foto</span>
                </div>
            @endif

            <div class="glass-body">

                <div class="glass-title">{{ $item->name }}</div>

                <div class="glass-meta">
                    <strong>Kategori:</strong> {{ $item->category->name }}
                </div>

                <div class="glass-meta">
                    <strong>Kondisi:</strong> {{ $item->condition }}
                </div>

                <span class="badge glass-badge bg-primary">
                    {{ ucfirst($item->status) }}
                </span>

                <div class="mt-3 d-flex flex-column gap-2">

                    <!-- Lihat Foto -->
                    @if($item->photo)
                    <a href="{{ asset('storage/'.$item->photo) }}" target="_blank" class="btn btn-outline-primary btn-sm">
                        <i class="bi bi-image"></i> Lihat Foto
                    </a>
                    @endif

                    <!-- EDIT -->
                    <a href="{{ route('items.edit', $item->id) }}" class="btn btn-warning btn-sm">
                        <i class="bi bi-pencil"></i> Edit
                    </a>

                    <!-- HAPUS -->
                    <form action="{{ route('items.destroy', $item->id) }}" method="POST">
                        @csrf @method('DELETE')
                        <button class="btn btn-danger btn-sm w-100">
                            <i class="bi bi-trash"></i> Hapus
                        </button>
                    </form>

                    <!-- DESKRIPSI COLLAPSE -->
                    <button class="btn btn-outline-secondary btn-sm"
                            data-bs-toggle="collapse"
                            data-bs-target="#desc-{{ $item->id }}">
                        <i class="bi bi-chevron-down"></i> Deskripsi
                    </button>

                    <div id="desc-{{ $item->id }}" class="collapse mt-2">
                        <div class="p-2 rounded"
                            style="background: rgba(255,255,255,0.35); backdrop-filter: blur(6px); border: 1px solid rgba(255,255,255,0.4);">
                            <p class="mb-0" style="white-space: pre-line;">
                                {{ $item->description ?? 'Tidak ada deskripsi.' }}
                            </p>
                        </div>
                    </div>

                    <!-- ADMIN ONLY — STATUS BUTTONS -->
                    @if(auth()->user()->role === 'admin')

                        <!-- PENDING → VERIFIED -->
                        @if($item->status === 'pending')
                            <form method="POST" action="{{ route('items.updateStatus', [$item->id, 'verified']) }}">
                                @csrf @method('PATCH')
                                <button class="btn btn-success btn-sm">
                                    <i class="bi bi-check-circle"></i> Verifikasi
                                </button>
                            </form>
                        @endif

                        <!-- VERIFIED → READY -->
                        @if($item->status === 'verified')
                            <form method="POST" action="{{ route('items.updateStatus', [$item->id, 'ready']) }}">
                                @csrf @method('PATCH')
                                <button class="btn btn-primary btn-sm">
                                    <i class="bi bi-box-seam"></i> Siap Distribusi
                                </button>
                            </form>
                        @endif

                    @endif
                    
                    
                </div>
            </div>


        </div>

    </div>
    @endforeach

</div>

<div class="mt-4">
    {{ $items->links() }}
</div>

@endsection
