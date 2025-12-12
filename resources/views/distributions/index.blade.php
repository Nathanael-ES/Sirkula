@extends('layouts.app')

@section('content')

    {{-- 1. CSS STYLING --}}
    <style>
        body {
            font-family: 'Poppins', sans-serif !important;
        }

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

        /* Kartu Overlap */
        .cards-container {
            margin-top: -8rem;
            position: relative;
            z-index: 10;
        }

        /* Modal Styling */
        .modal {
            z-index: 10055 !important;
        }

        .modal-backdrop.show {
            backdrop-filter: blur(5px);
            opacity: 0.5;
            background-color: rgba(0, 0, 0, 0.5);
        }

        .modal-content {
            border-radius: 16px;
            border: none;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
        }

        .modal-header {
            border-bottom: 1px solid #f0f0f0;
            padding: 20px 24px;
        }

        .modal-body {
            padding: 24px;
        }

        .modal-footer {
            border-top: none;
            padding: 0 24px 24px 24px;
        }

        .form-control,
        .form-select {
            border-radius: 8px;
            padding: 10px 12px;
            border: 1px solid #e0e0e0;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #3C91FF;
            box-shadow: 0 0 0 3px rgba(60, 145, 255, 0.1);
        }
    </style>

    {{-- 2. HEADER --}}
    <div class="container-fluid dashboard-header">
        <div class="container mt-0">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="fw-semibold">{{ __('messages.distribution_list') }}</h2>
                    <p class="text-white-50 mb-0">Riwayat penyaluran barang bantuan kepada penerima.</p>
                </div>
                {{-- Tombol Trigger Modal --}}
                <button class="btn btn-light text-primary fw-bold shadow-sm px-4" data-bs-toggle="modal"
                    data-bs-target="#createDistributionModal">
                    <i class='bx bx-plus me-1'></i> {{ __('messages.add_distribution') }}
                </button>
            </div>
        </div>
    </div>

    {{-- 3. CONTENT --}}
    <div class="container cards-container">
        <div class="row">
            <div class="col-12">

                {{-- Search Bar --}}
                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-body p-3">
                        <form method="GET" class="row g-2 align-items-center">
                            <div class="col-md-10">
                                <div class="input-group">
                                    <span class="input-group-text bg-white border-end-0"><i
                                            class='bx bx-search text-muted'></i></span>
                                    <input type="text" name="search" value="{{ request('search') }}"
                                        class="form-control border-start-0" placeholder="{{ __('messages.search') }}...">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <button class="btn btn-primary w-100 fw-bold"
                                    style="background-color: #3C91FF; border:none;">
                                    {{ __('messages.search') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                {{-- Tabel Data --}}
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                    <div class="card-body p-0">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="ps-4 py-3 text-secondary small text-uppercase">{{ __('messages.item_name') }}
                                    </th>
                                    <th class="py-3 text-secondary small text-uppercase">{{ __('messages.recipient_name') }}
                                    </th>
                                    <th class="py-3 text-secondary small text-uppercase">{{ __('messages.distributed_at') }}
                                    </th>
                                    <th class="py-3 text-secondary small text-uppercase">{{ __('messages.volunteer') }}</th>
                                    <th class="pe-4 py-3 text-end text-secondary small text-uppercase">
                                        {{ __('messages.action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($distributions as $dist)
                                    <tr>
                                        <td class="ps-4">
                                            <div class="d-flex align-items-center">
                                                <div class="bg-success bg-opacity-10 text-success rounded-circle d-flex align-items-center justify-content-center me-3"
                                                    style="width: 40px; height: 40px;">
                                                    <i class='bx bxs-package fs-5'></i>
                                                </div>
                                                <div>
                                                    <h6 class="mb-0 fw-semibold text-dark">{{ $dist->item->name }}</h6>
                                                    <small class="text-muted">{{ $dist->item->condition }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <i class='bx bx-user-pin fs-4 text-secondary me-2'></i>
                                                <span class="fw-medium text-dark">{{ $dist->recipient->name }}</span>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center text-muted">
                                                <i class='bx bx-calendar me-2'></i>
                                                {{ \Carbon\Carbon::parse($dist->distributed_at)->format('d M Y, H:i') }}
                                            </div>
                                        </td>
                                        <td>
                                            @if($dist->volunteer)
                                                <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-3">
                                                    {{ $dist->volunteer->name }}
                                                </span>
                                            @else
                                                <span class="text-muted small">-</span>
                                            @endif
                                        </td>
                                        <td class="text-end pe-4">
                                            <form action="{{ route('distributions.destroy', $dist->id) }}" method="POST"
                                                class="d-inline"
                                                onsubmit="return confirm('Yakin ingin menghapus data distribusi ini?')">
                                                @csrf @method('DELETE')
                                                <button class="btn btn-link text-danger p-0 opacity-75 hover-opacity-100"
                                                    title="{{ __('messages.delete') }}">
                                                    <i class='bx bxs-trash fs-5'></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-5">
                                            <i class='bx bx-paper-plane fs-1 text-muted opacity-25 mb-3'></i>
                                            <p class="text-muted mb-0">{{ __('messages.no_data') }}</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    @if($distributions->hasPages())
                        <div class="card-footer bg-white border-0 py-3">
                            {{ $distributions->links() }}
                        </div>
                    @endif
                </div>

            </div>
        </div>
    </div>

    {{-- 4. MODAL CREATE DISTRIBUTION --}}
    <div class="modal fade" id="createDistributionModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">{{ __('messages.add_distribution') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('distributions.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">

                        {{-- Pilih Barang --}}
                        <div class="mb-3">
                            <label class="form-label small text-muted fw-bold">{{ __('messages.item_name') }}</label>
                            <select name="item_id" class="form-select @error('item_id') is-invalid @enderror" required>
                                <option value="" disabled selected>{{ __('messages.item_name') }}...</option>
                                @forelse($items as $item)
                                    <option value="{{ $item->id }}">
                                        {{ $item->name }} (Stok: {{ $item->status }})
                                    </option>
                                @empty
                                    <option value="" disabled>Tidak ada barang yang Ready</option>
                                @endforelse
                            </select>
                            @error('item_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        {{-- Pilih Penerima --}}
                        <div class="mb-3">
                            <label class="form-label small text-muted fw-bold">{{ __('messages.recipient_name') }}</label>
                            <select name="recipient_id" class="form-select @error('recipient_id') is-invalid @enderror"
                                required>
                                <option value="" disabled selected>{{ __('messages.recipient_name') }}...</option>
                                @foreach($recipients as $r)
                                    <option value="{{ $r->id }}">{{ $r->name }}</option>
                                @endforeach
                            </select>
                            @error('recipient_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light"
                            data-bs-dismiss="modal">{{ __('messages.cancel') }}</button>
                        <button type="submit" class="btn btn-primary px-4"
                            style="background-color: #3C91FF; border:none;">{{ __('messages.create') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- 5. SCRIPT (Open Modal if Error) --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            @if ($errors->any())
                var myModal = new bootstrap.Modal(document.getElementById('createDistributionModal'));
                myModal.show();
            @endif
        });
    </script>

@endsection