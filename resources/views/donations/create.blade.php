@extends('layouts.app')

@section('content')

<style>
    body { font-family: 'Poppins', sans-serif !important; }
    .fs-22 { font-size: 1.375rem; }

    .dashboard-header {
        background-color: #3C91FF;
        color: white;
        padding-top: 3rem;
        padding-bottom: 9rem; 
        border-radius: 0;
        margin: 0;
        width: 100%;
    }

    .cards-container {
        margin-top: -8rem; 
        position: relative; 
        z-index: 10;
    }

    .modal { z-index: 10055 !important; }
    .modal-backdrop.show {
        backdrop-filter: blur(5px);
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

<div class="container-fluid dashboard-header">
    <div class="container mt-0">
        <h2 class="fw-semibold">{{ __('messages.donation_list') }}</h2>
        <p class="opacity-75">Kelola data donasi barang di sini</p>
    </div>
</div>

<div class="container cards-container">
    <div class="row">
        <div class="col-12">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mb-3 gap-3">
                <form method="GET" class="w-100 w-md-50 d-flex shadow-sm rounded-3 overflow-hidden">
                    <input type="text" name="search" class="form-control border-0 px-3 py-2" 
                           placeholder="{{ __('messages.search') }}..." 
                           value="{{ request('search') }}">
                    <button class="btn btn-light bg-white border-0 text-primary px-3">
                        <i class='bx bx-search'></i>
                    </button>
                </form>

                <button class="btn btn-light text-primary fw-bold shadow-sm py-2 px-4" 
                        data-bs-toggle="modal" data-bs-target="#createDonationModal">
                    <i class='bx bx-plus me-1'></i> {{ __('messages.add_donation') }}
                </button>
            </div>

            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-body p-0">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4 py-3 text-secondary small text-uppercase">{{ __('messages.item_name') }}</th>
                                <th class="py-3 text-secondary small text-uppercase">{{ __('messages.donor') }}</th>
                                <th class="pe-4 py-3 text-end text-secondary small text-uppercase">{{ __('messages.action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($donations as $d)
                            <tr>
                                <td class="ps-4">
                                    <div class="d-flex align-items-center">
                                        <div class="bg-warning bg-opacity-10 text-warning rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                            <i class='bx bxs-box fs-5'></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-0 fw-semibold text-dark">{{ $d->item->name }}</h6>
                                            <small class="text-muted">{{ $d->item->condition ?? '-' }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <i class='bx bx-user-circle fs-4 text-secondary me-2'></i>
                                        <span class="fw-medium text-dark">{{ $d->donor->name }}</span>
                                    </div>
                                </td>
                                <td class="text-end pe-4">
                                    @if(auth()->user()->role == 'donatur' || auth()->user()->id == $d->donor_id)
                                        <form method="POST" action="{{ route('donations.destroy', $d->id) }}" class="d-inline" onsubmit="return confirm('{{ __('messages.confirm_delete') }}?')">
                                            @csrf @method('DELETE')
                                            <button class="btn btn-link text-danger p-0 opacity-75 hover-opacity-100" title="{{ __('messages.delete') }}">
                                                <i class='bx bxs-trash fs-5'></i>
                                            </button>
                                        </form>
                                    @else
                                        <span class="text-muted small">-</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="text-center py-5 text-muted">
                                    <img src="https://cdn-icons-png.flaticon.com/512/7486/7486754.png" width="60" class="mb-3 opacity-50" alt="No Data">
                                    <p class="mb-0">{{ __('messages.no_data') }}</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($donations->hasPages())
                <div class="card-footer bg-white border-0 py-3">
                    {{ $donations->links() }}
                </div>
                @endif
            </div>

        </div>
    </div>
</div>

<div class="modal fade" id="createDonationModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fw-bold">{{ __('messages.add_donation') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('donations.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label small text-muted fw-bold">{{ __('messages.item_name') }}</label>
                        <select name="item_id" class="form-select" required>
                            <option value="" disabled selected>{{ __('messages.select_item') ?? 'Pilih Barang' }}</option>
                            @if(isset($items))
                                @foreach($items as $it)
                                    <option value="{{ $it->id }}">{{ $it->name }} ({{ $it->condition }})</option>
                                @endforeach
                            @else
                                <option value="" disabled>Data barang tidak ditemukan</option>
                            @endif
                        </select>
                        @error('item_id') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">{{ __('messages.cancel') }}</button>
                    <button type="submit" class="btn btn-primary px-4">{{ __('messages.create') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        @if ($errors->any())
            var myModal = new bootstrap.Modal(document.getElementById('createDonationModal'));
            myModal.show();
        @endif
    });
</script>

@endsection