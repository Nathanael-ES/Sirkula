@extends('layouts.app')

@section('content')

{{-- 1. CSS STYLING (Tema Dashboard & Modal Blur) --}}
<style>
    body { font-family: 'Poppins', sans-serif !important; }
    .fs-22 { font-size: 1.375rem; }

    /* Header Biru */
    .dashboard-header {
        background-color: #3C91FF;
        color: white;
        padding-top: 3rem;
        padding-bottom: 9rem; 
        border-radius: 0 0 1.2rem 1.2rem;
        margin: 0;
        width: 100%;
    }

    /* Posisi Kartu Overlap */
    .cards-container {
        margin-top: -8rem; 
        position: relative; 
        z-index: 10;
    }

    /* --- STYLING MODAL (Fix Blur & Z-Index) --- */
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
    
    .form-control, .form-select {
        border-radius: 8px; padding: 10px 12px; border: 1px solid #e0e0e0;
    }
    .form-control:focus, .form-select:focus {
        border-color: #3C91FF; box-shadow: 0 0 0 3px rgba(60, 145, 255, 0.1);
    }
</style>

{{-- 2. HEADER BIRU --}}
<div class="container-fluid dashboard-header">
    <div class="container mt-0">
        <h2 class="fw-semibold">{{ __('messages.users') }}</h2> </div>
</div>

{{-- 3. KONTEN UTAMA --}}
<div class="container cards-container">
    
    <div class="row">
        <div class="col-12">
            
            {{-- Header Tabel --}}
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="fw-bold text-white mb-0">Daftar Pengguna</h5>
                <button class="btn btn-light text-primary fw-bold shadow-sm" data-bs-toggle="modal" data-bs-target="#createUserModal">
                    <i class='bx bx-plus me-1'></i> {{ __('messages.add_user') }}
                </button>
            </div>

            {{-- Kartu Tabel --}}
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-body p-0">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4 py-3 text-secondary small text-uppercase">#</th>
                                <th class="py-3 text-secondary small text-uppercase">{{ __('messages.name') }}</th>
                                <th class="py-3 text-secondary small text-uppercase">{{ __('messages.email') }}</th>
                                <th class="py-3 text-secondary small text-uppercase">{{ __('messages.role') }}</th>
                                <th class="pe-4 py-3 text-end text-secondary small text-uppercase">{{ __('messages.action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($users as $index => $u)
                            <tr>
                                <td class="ps-4 text-muted">{{ $users->firstItem() + $index }}</td>
                                <td class="fw-medium text-dark">
                                    <div class="d-flex align-items-center">
                                        <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 35px; height: 35px;">
                                            <i class='bx bxs-user'></i>
                                        </div>
                                        {{ $u->name }}
                                    </div>
                                </td>
                                <td class="text-muted">{{ $u->email }}</td>
                                <td>
                                    @if($u->role == 'admin')
                                        <span class="badge bg-danger bg-opacity-10 text-danger rounded-pill px-3">Admin</span>
                                    @elseif($u->role == 'relawan')
                                        <span class="badge bg-info bg-opacity-10 text-info rounded-pill px-3">Relawan</span>
                                    @else
                                        <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3">Donatur</span>
                                    @endif
                                </td>
                                <td class="text-end pe-4">
                                    <a href="#" class="text-secondary opacity-75 me-3 text-decoration-none"
                                       data-bs-toggle="modal" 
                                       data-bs-target="#editUserModal"
                                       data-id="{{ $u->id }}"
                                       data-name="{{ $u->name }}"
                                       data-email="{{ $u->email }}"
                                       data-role="{{ $u->role }}">
                                        <i class='bx bxs-pencil fs-5'></i>
                                    </a>

                                    @if(auth()->id() !== $u->id) <form action="{{ route('admin.users.destroy', $u->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus user ini?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="border-0 bg-transparent text-secondary opacity-75 p-0">
                                            <i class='bx bxs-trash fs-5'></i>
                                        </button>
                                    </form>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center py-5 text-muted">Belum ada data user.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if($users->hasPages())
                <div class="card-footer bg-white border-0 py-3">
                    {{ $users->links() }}
                </div>
                @endif
            </div>

        </div>
    </div>
</div>

{{-- 4. MODALS --}}
@include('users.modals.create')
@include('users.modals.edit')

{{-- 5. JAVASCRIPT LOGIC --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var editUserModal = document.getElementById('editUserModal');
        
        if (editUserModal) {
            editUserModal.addEventListener('show.bs.modal', function (event) {
                // 1. Ambil tombol yang diklik
                var button = event.relatedTarget;
                
                // 2. Ambil data dari atribut tombol
                var id = button.getAttribute('data-id');
                var name = button.getAttribute('data-name');
                var email = button.getAttribute('data-email');
                var role = button.getAttribute('data-role');
                
                // 3. Isi form dalam modal
                editUserModal.querySelector('#editName').value = name;
                editUserModal.querySelector(    '#editEmail').value = email;
                editUserModal.querySelector('#editRole').value = role;

                // 4. Update URL Action Form
                var form = editUserModal.querySelector('#editUserForm');
                var updateUrl = "{{ route('admin.users.update', ':id') }}";
                updateUrl = updateUrl.replace(':id', id);
                form.action = updateUrl;
            });
        }
    });
</script>

@endsection
