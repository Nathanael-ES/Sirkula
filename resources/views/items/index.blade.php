@extends('layouts.app')

@section('content')

{{-- 1. CSS STYLING --}}
<style>
    body { font-family: 'Poppins', sans-serif !important; }
    .fs-22 { font-size: 1.375rem; }

    /* Header Biru Standard */
    .dashboard-header {
        background-color: #3C91FF;
        color: white;
        padding-top: 2.5rem;
        padding-bottom: 10rem; 
        border-radius: 0 0 1.2rem 1.2rem;
        margin: 0;
    }

    /* Posisi Kartu Overlap */
    .cards-container {
        margin-top: -9rem; 
        position: relative; 
        z-index: 10;
    }

    /* Styling Kartu Katalog */
    .catalog-card {
        border: none;
        border-radius: 12px;
        background: white;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        transition: transform 0.2s, box-shadow 0.2s;
        overflow: hidden;
        height: 100%;
    }
    .catalog-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.15);
    }

    /* Area Gambar */
    .catalog-img-wrapper {
        height: 180px; width: 100%;
        background-color: #f8f9fa;
        display: flex; align-items: center; justify-content: center;
        overflow: hidden; position: relative;
    }
    .catalog-img { width: 100%; height: 100%; object-fit: cover; }

    /* Fix Modal Z-Index & Blur */
    .modal { z-index: 10055 !important; }
    .modal-backdrop { z-index: 10050 !important; }
    .modal-backdrop.show {
        backdrop-filter: blur(5px); -webkit-backdrop-filter: blur(5px);
        opacity: 0.5; background-color: rgba(0, 0, 0, 0.5);
    }
    .modal-content { border-radius: 16px; border: none; box-shadow: 0 10px 40px rgba(0,0,0,0.2); }
    .modal-header { border-bottom: 1px solid #f0f0f0; padding: 20px 24px; }
    .modal-body { padding: 24px; }
    .modal-footer { border-top: none; padding: 0 24px 24px 24px; }
    
    .form-control, .form-select { border-radius: 8px; padding: 10px 12px; border: 1px solid #e0e0e0; }
    .form-control:focus, .form-select:focus { border-color: #3C91FF; box-shadow: 0 0 0 3px rgba(60, 145, 255, 0.1); }
</style>

{{-- 2. HEADER --}}
<div class="container-fluid dashboard-header">
    <div class="container mt-0">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2 class="fw-semibold">Katalog Barang</h2>
                <p class="text-white-50 mb-0">Kelola stok dan distribusi barang bantuan.</p>
            </div>
            <button class="btn btn-light text-primary fw-bold shadow-sm px-4" data-bs-toggle="modal" data-bs-target="#createItemModal">
                <i class='bx bx-plus me-1'></i> Tambah
            </button>
        </div>
    </div>
</div>

{{-- 3. KONTEN (FILTER & GRID) --}}
<div class="container cards-container">
    
    {{-- Filter Card --}}
    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-body p-4">
            <form method="GET" class="row g-3">
                <div class="col-md-4">
                    <label class="form-label small text-muted fw-bold">Pencarian</label>
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0"><i class='bx bx-search text-muted'></i></span>
                        <input type="text" name="search" value="{{ request('search') }}" class="form-control border-start-0" placeholder="Cari nama barang...">
                    </div>
                </div>
                <div class="col-md-3">
                    <label class="form-label small text-muted fw-bold">Kategori</label>
                    <select name="category" class="form-select">
                        <option value="">Semua Kategori</option>
                        @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label small text-muted fw-bold">Status</label>
                    <select name="status" class="form-select">
                        <option value="">Semua Status</option>
                        <option value="pending" {{ request('status')=='pending'?'selected':'' }}>Pending</option>
                        <option value="verified" {{ request('status')=='verified'?'selected':'' }}>Terverifikasi</option>
                        <option value="ready" {{ request('status')=='ready'?'selected':'' }}>Siap Distribusi</option>
                    </select>
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button class="btn btn-primary w-100 fw-bold" style="background-color: #3C91FF; border:none;">Filter</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Grid Barang --}}
    <div class="row g-4 mt-2">
        @forelse($items as $item)
        <div class="col-md-6 col-lg-4 col-xl-3">
            <div class="catalog-card h-100 d-flex flex-column">
                
                {{-- Foto --}}
                <div class="catalog-img-wrapper">
                    @if($item->photo)
                        <img src="{{ asset('storage/'.$item->photo) }}" class="catalog-img">
                    @else
                        <div class="text-center text-muted">
                            <i class='bx bx-image fs-1 mb-2 opacity-50'></i><br><small>Tidak ada foto</small>
                        </div>
                    @endif
                    <div class="position-absolute top-0 end-0 m-3">
                        @if($item->status == 'pending') <span class="badge bg-warning text-dark shadow-sm">Pending</span>
                        @elseif($item->status == 'verified') <span class="badge bg-info text-white shadow-sm">Verified</span>
                        @elseif($item->status == 'ready') <span class="badge bg-success shadow-sm">Siap Kirim</span>
                        @else <span class="badge bg-secondary shadow-sm">{{ ucfirst($item->status) }}</span> @endif
                    </div>
                </div>

                {{-- Info --}}
                <div class="p-3 flex-grow-1">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-2 small">
                            {{ $item->category->name ?? 'Umum' }}
                        </span>
                        <small class="text-muted" style="font-size: 0.75rem;">{{ $item->created_at->format('d M') }}</small>
                    </div>
                    <h6 class="fw-bold mb-1 text-truncate" title="{{ $item->name }}">{{ $item->name }}</h6>
                    <p class="text-muted small mb-2"><i class='bx bx-purchase-tag-alt text-secondary'></i> {{ $item->condition }}</p>
                    <p class="text-secondary small mb-0" style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; height: 38px;">
                        {{ $item->description ?? 'Tidak ada deskripsi.' }}
                    </p>
                </div>

                {{-- Footer Tombol --}}
                <div class="p-3 border-top bg-light bg-opacity-25">
                    <div class="row g-2">
                        <div class="col-6">
                            {{-- [UPDATE 1] Menambahkan data-status --}}
                            <button class="btn btn-outline-secondary btn-sm w-100 fw-medium" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#editItemModal"
                                    data-id="{{ $item->id }}"
                                    data-name="{{ $item->name }}"
                                    data-category="{{ $item->category_id }}"
                                    data-condition="{{ $item->condition }}"
                                    data-description="{{ $item->description }}"
                                    data-status="{{ $item->status }}"
                                    data-photo="{{ $item->photo ? asset('storage/'.$item->photo) : '' }}">
                                <i class='bx bxs-pencil'></i> Edit
                            </button>
                        </div>
                        <div class="col-6">
                            <form action="{{ route('items.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Hapus barang ini?');">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger btn-sm w-100 fw-medium">
                                    <i class='bx bxs-trash'></i> Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12 text-center py-5 text-muted">
            <i class='bx bx-box fs-1 mb-3 opacity-50'></i><p>Belum ada data barang.</p>
        </div>
        @endforelse
    </div>

    <div class="mt-4">{{ $items->links() }}</div>
</div>

{{-- 4. PANGGIL MODAL --}}
@include('items.modals.create')
@include('items.modals.edit')

{{-- 5. JAVASCRIPT LOGIC --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var editItemModal = document.getElementById('editItemModal');
        
        if (editItemModal) {
            editItemModal.addEventListener('show.bs.modal', function (event) {
                var button = event.relatedTarget;
                
                // Ambil data
                var id = button.getAttribute('data-id');
                var name = button.getAttribute('data-name');
                var category = button.getAttribute('data-category');
                var condition = button.getAttribute('data-condition');
                var description = button.getAttribute('data-description');
                var photoUrl = button.getAttribute('data-photo');
                // [UPDATE 2] Ambil data status
                var status = button.getAttribute('data-status'); 
                
                // Isi Form
                editItemModal.querySelector('#editName').value = name;
                editItemModal.querySelector('#editCategory').value = category;
                editItemModal.querySelector('#editCondition').value = condition;
                editItemModal.querySelector('#editDescription').value = description;

                // [UPDATE 3] Isi Dropdown Status (Jika input ada di modal)
                var statusSelect = editItemModal.querySelector('#editStatus');
                if(statusSelect) {
                    statusSelect.value = status;
                }

                // Handle Preview Foto
                var previewContainer = editItemModal.querySelector('#editPhotoPreviewContainer');
                var previewImg = editItemModal.querySelector('#editPhotoPreview');
                
                if (photoUrl) {
                    previewImg.src = photoUrl;
                    previewContainer.classList.remove('d-none');
                } else {
                    previewContainer.classList.add('d-none');
                }

                // Update URL Action
                var form = editItemModal.querySelector('#editItemForm');
                var updateUrl = "{{ route('items.update', ':id') }}";
                updateUrl = updateUrl.replace(':id', id);
                form.action = updateUrl;
            });
        }
    });
</script>

@endsection