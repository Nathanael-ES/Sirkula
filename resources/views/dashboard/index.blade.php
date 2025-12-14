@extends('layouts.app')

@section('content')

<style>
    .fs-22 { font-size: 1.375rem; }

    .dashboard-header {
        background-color: #3C91FF;
        color: white;
        padding-top: 3rem;
        padding-bottom: 9rem; 
        border-radius: 0 0 1.2rem 1.2rem;
        margin: 0;
        width: 100%;
    }


    .cards-container {
        margin-top: -8rem; 
        position: relative; 
        z-index: 10;
    }


    .stat-card {
        border: none;
        border-radius: 12px;
        background-color: #f3f4f6;
        transition: transform 0.2s;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    }
    .stat-card:hover { transform: translateY(-5px); }

    .icon-box {
        width: 45px; height: 45px;
        border-radius: 10px;
        display: flex; align-items: center; justify-content: center;
    }
    .bg-icon-blue { background-color: #dbeafe; color: #3C91FF; }

    .modal { z-index: 10055 !important; }
    .modal-backdrop { z-index: 10050 !important; }
    
    .modal-backdrop.show {
        backdrop-filter: blur(5px);
        -webkit-backdrop-filter: blur(5px);
        opacity: 0.5;
        background-color: rgba(0, 0, 0, 0.5);
    }

    .modal-content {
        border-radius: 16px; border: none;
        box-shadow: 0 10px 40px rgba(0,0,0,0.2);
    }
    .modal-header { border-bottom: 1px solid #f0f0f0; padding: 20px 24px; }
    .modal-body { padding: 24px; }
    .modal-footer { border-top: none; padding: 0 24px 24px 24px; }
    
    .form-control {
        border-radius: 8px; padding: 10px 12px; border: 1px solid #e0e0e0;
    }
    .form-control:focus {
        border-color: #3C91FF; box-shadow: 0 0 0 3px rgba(60, 145, 255, 0.1);
    }
</style>


<div class="container-fluid dashboard-header">
    <div class="container mt-0">
        <h2 class="fw-semibold">Dashboard</h2>
    </div>
</div>

<!-- Card -->
<div class="container cards-container">
    
        <div class="row g-4">
        <div class="col-md-3">
            <div class="card stat-card p-4 h-100">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <h6 class="fs-22 text-muted mb-2">{{ __('messages.item_count') }}</h6>
                        <h2 class="fs-1 mt-4 text-dark">{{ $totalItems ?? 0 }}</h2>
                    </div>
                    <div class="icon-box bg-icon-blue">
                        <i class="bi bi-archive-fill fs-5"></i>
                    </div>
                </div>
                <div class="d-flex align-items-center gap-2 mt-2 small">
                    <i class='bx bxs-circle' style='color:#ff5555; font-size: 8px;'></i>
                    <span class="text-muted">{{ $pending ?? 0 }} Pending</span>
                    <i class='bx bxs-circle ms-2' style='color:#6ffa66; font-size: 8px;'></i> 
                    <span class="text-muted">{{ $verified ?? 0 }} Verified</span>
                </div>
            </div>
        </div>

        <div class="col-md-3">
        <div class="card stat-card p-4 h-100">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <h6 class="fs-22 text-muted mb-2">{{ __('messages.ready_count') }}</h6>
                    <h2 class="fs-1 mt-4 text-dark">{{ $ready ?? 0 }}</h2>
                </div>
                <div class="icon-box bg-icon-blue">
                    <i class="bi bi-send-fill fs-5"></i>
                </div>
            </div>
            <div class="d-flex align-items-center gap-2 mt-2 small">
                {{-- Logika: Jika ada data baru hari ini, titik ijo nyala --}}
                @if($recentReady > 0)
                    <i class='bx bxs-circle' style='color:#6ffa66; font-size: 8px;'></i> 
                    <span class="text-muted">+{{ $recentReady }} Baru Hari Ini</span>
                @else
                    <i class='bx bxs-circle' style='color:#ff5555; font-size: 8px;'></i>
                    <span class="text-muted">{{ __('messages.no_changes_today') }}</span>
                @endif
            </div>
        </div>
    </div>

       <div class="col-md-3">
        <div class="card stat-card p-4 h-100">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <h6 class="fs-22 text-muted mb-2">{{ __('messages.distribution_count') }}</h6>
                    <h2 class="fs-1 mt-4 text-dark">{{ $totalDistribution ?? 0 }}</h2>
                </div>
                <div class="icon-box bg-icon-blue">
                    <i class="bi bi-truck fs-5"></i>
                </div>
            </div>
            <div class="d-flex align-items-center gap-2 mt-2 small">
                @if($recentDist > 0)
                    <i class='bx bxs-circle' style='color:#6ffa66; font-size: 8px;'></i> 
                    <span class="text-muted">+{{ $recentDist }} Dikirim Hari Ini</span>
                @else
                <i class='bx bxs-circle' style='color:#ff5555; font-size: 8px;'></i>
                    <span class="text-muted">{{ __('messages.no_activity') }}</span>
                @endif
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card stat-card p-4 h-100">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <h6 class="fs-22 text-muted mb-2">{{ __('messages.recipient_count') }}</h6>
                    <h2 class="fs-1 mt-4 text-dark">{{ $totalRecipients ?? 0 }}</h2>
                </div>
                <div class="icon-box bg-icon-blue">
                    <i class="bi bi-people-fill fs-5"></i>
                </div>
            </div>
            <div class="d-flex align-items-center gap-2 mt-2 small">
                @if($recentRecipients > 0)
                    <i class='bx bxs-circle' style='color:#6ffa66; font-size: 8px;'></i> 
                    <span class="text-muted">+{{ $recentRecipients }} Akun Baru</span>
                @else
                    <span class="text-muted">{{ __('messages.no_new_user') }}</span>
                @endif
            </div>
        </div>
    </div>
    
    {{-- Spacer --}}
    <div style="margin-top: 2rem;"></div>

    <div class="row g-4">
        {{-- Tabel Kiri: Kategori --}}
        <div class="col-md-6">
            <div class="section-title d-flex justify-content-between fs-22 align-items-center mb-3">
                <span class="fw-bold">{{ __('messages.category_list') }}</span>
                @if(auth()->user()->role === 'admin')
                <button class="btn btn-sm text-secondary" data-bs-toggle="modal" data-bs-target="#createCategoryModal">
                    <i class='bx bx-plus fs-4'></i> 
                </button>
                @endif 
            </div>

            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="fw-normal ps-4 py-3">{{ __('messages.category_name') }}</th>
                            <th class="fw-normal py-3">Deskripsi</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($categories as $c)
                        <tr>
                            <td class="ps-4 fw-medium">{{ $c->name }}</td>
                            <td class="text-muted small">{{ Str::limit($c->description, 30) }}</td>
                            <td class="text-end pe-4">
                            @if(auth()->user()->role === 'admin')
                                <a href="#" class="text-secondary opacity-75 me-3 text-decoration-none"
                                   data-bs-toggle="modal" 
                                   data-bs-target="#editCategoryModal"
                                   data-id="{{ $c->id }}"
                                   data-name="{{ $c->name }}"
                                   data-description="{{ $c->description }}">
                                    <i class='bx bxs-pencil fs-5'></i>
                                </a> 
                                <form action="{{ route('admin.categories.destroy', $c->id) }}" method="POST" class="d-inline" onsubmit="return confirm('{{ __('messages.confirm_delete') }}')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="border-0 bg-transparent text-secondary opacity-75 p-0">
                                        <i class='bx bxs-trash fs-5'></i>
                                    </button>
                                </form>
                            @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        
        {{-- Tabel Kanan: Penerima --}}
        <div class="col-md-6">
            <div class="section-title d-flex justify-content-between fs-22 align-items-center mb-3">
                <span class="fw-bold">{{ __('messages.recipient_list') }}</span>
                @if(auth()->user()->role === 'admin')
                <button class="btn btn-sm text-secondary" data-bs-toggle="modal" data-bs-target="#createRecipientModal">
                    <i class='bx bx-plus fs-4'></i> 
                </button>
                @endif 
            </div>

            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="fw-normal ps-4 py-3">{{ __('messages.recipient_name') }}</th>
                            <th class="fw-normal py-3">Info Kontak</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recipients as $r)
                        <tr>
                            <td class="ps-4 fw-medium">{{ $r->name }}</td>
                            <td class="text-muted small">{{ Str::limit($r->phone, 30) }}</td>
                            <td class="text-end pe-4">
                                @if(auth()->user()->role === 'admin')
                                <a href="#" class="text-secondary opacity-75 me-3 text-decoration-none"
                                   data-bs-toggle="modal" 
                                   data-bs-target="#editRecipientModal"
                                   data-id="{{ $r->id }}"
                                   data-name="{{ $r->name }}"
                                   data-address="{{ $r->address }}"
                                   data-phone="{{ $r->phone }}">
                                    <i class='bx bxs-pencil fs-5'></i>
                                </a> 
                                <form action="{{ route('recipients.destroy', $r->id) }}" method="POST" class="d-inline" onsubmit="return confirm('{{ __('messages.confirm_delete') }}')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="border-0 bg-transparent text-secondary opacity-75 p-0">
                                        <i class='bx bxs-trash fs-5'></i>
                                    </button>
                                </form>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@include('dashboard.modals.create')
@include('dashboard.modals.edit')

<script>
    document.addEventListener('DOMContentLoaded', function () {
        
        var modals = document.querySelectorAll('.modal');
        modals.forEach(function(modal) {
            document.body.appendChild(modal);
        });

        var editCatModal = document.getElementById('editCategoryModal');
        if (editCatModal) {
            editCatModal.addEventListener('show.bs.modal', function (event) {
                var button = event.relatedTarget;
                var id = button.getAttribute('data-id');
                var name = button.getAttribute('data-name');
                var description = button.getAttribute('data-description');
                
                editCatModal.querySelector('#editName').value = name;
                editCatModal.querySelector('#editDescription').value = description;

                var form = editCatModal.querySelector('#editCategoryForm');
                var updateUrl = "{{ route('admin.categories.update', ':id') }}";
                updateUrl = updateUrl.replace(':id', id);
                form.action = updateUrl;
            });
        }

        var editRecipModal = document.getElementById('editRecipientModal');
        if (editRecipModal) {
            editRecipModal.addEventListener('show.bs.modal', function (event) {
                var button = event.relatedTarget;
                var id = button.getAttribute('data-id');
                var name = button.getAttribute('data-name');
                var address = button.getAttribute('data-address');
                var phone = button.getAttribute('data-phone');
                
                var inputName = editRecipModal.querySelector('#editRecipientName');
                var inputAddress = editRecipModal.querySelector('#editRecipientAddress');
                var inputPhone = editRecipModal.querySelector('#editRecipientPhone');

                if(inputName) inputName.value = name;
                if(inputAddress) inputAddress.value = address;
                if(inputPhone) inputPhone.value = phone;

                var form = editRecipModal.querySelector('#editRecipientForm');
                var updateUrl = "{{ route('recipients.update', ':id') }}";
                updateUrl = updateUrl.replace(':id', id);
                form.action = updateUrl;
            });
        }
    });
</script>

@endsection