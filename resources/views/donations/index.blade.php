@extends('layouts.app')

@section('content')

    <style>
        body {
            font-family: 'Poppins', sans-serif !important;
        }

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

        .table-hover tbody tr:hover {
            background-color: #f9fafb;
        }

        .icon-circle {
            width: 40px; 
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }
    </style>

    <div class="container-fluid dashboard-header">
        <div class="container mt-0">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="fw-semibold">{{ __('messages.donation_list') }}</h2>
                    <p class="text-white-50 mb-0">Daftar barang donasi yang masuk ke sistem.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="container cards-container">
        <div class="row">
            <div class="col-12">

                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-body p-3">
                        <form method="GET" class="row g-2 align-items-center">
                            <div class="col-md-10">
                                <div class="input-group">
                                    <span class="input-group-text bg-white border-end-0">
                                        <i class='bx bx-search text-muted'></i>
                                    </span>
                                    <input type="text" name="search" value="{{ request('search') }}"
                                        class="form-control border-start-0" placeholder="Cari nama barang atau donatur...">
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

                <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="ps-4 py-3 text-secondary small text-uppercase">{{ __('messages.item_name') }}</th>
                                        <th class="py-3 text-secondary small text-uppercase">{{ __('messages.category') }}</th>
                                        <th class="py-3 text-secondary small text-uppercase">{{ __('messages.donor') }}</th>
                                        <th class="py-3 text-secondary small text-uppercase">{{ __('messages.status') }}</th>
                                        
                                        @if(auth()->user()->role !== 'donatur')
                                            <th class="pe-4 py-3 text-end text-secondary small text-uppercase">{{ __('messages.action') }}</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($donations as $d)
                                        <tr>
                                            <td class="ps-4">
                                                <div class="d-flex align-items-center">
                                                    <div class="icon-circle bg-warning bg-opacity-10 text-warning me-3">
                                                        <i class='bx bxs-gift fs-5'></i>
                                                    </div>
                                                    <div>
                                                        <h6 class="mb-0 fw-semibold text-dark">{{ $d->item->name }}</h6>
                                                        <small class="text-muted">{{ Str::limit($d->item->description, 30) ?? '-' }}</small>
                                                    </div>
                                                </div>
                                            </td>

                                            <td>
                                                <span class="badge bg-light text-secondary border rounded-pill px-3">
                                                    {{ $d->item->category->name ?? '-' }}
                                                </span>
                                            </td>

                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <i class='bx bx-user-circle fs-4 text-secondary me-2'></i>
                                                    <div>
                                                        <div class="fw-medium text-dark">{{ $d->donor->name }}</div>
                                                        <div class="text-muted small" style="font-size: 0.75rem;">{{ $d->donor->email }}</div>
                                                    </div>
                                                </div>
                                            </td>

                                            <td>
                                                @if($d->item->status == 'ready')
                                                    <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3 py-2">
                                                        <i class='bx bxs-check-circle me-1'></i> Ready
                                                    </span>
                                                @elseif($d->item->status == 'distributed')
                                                    <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-3 py-2">
                                                        <i class='bx bxs-truck me-1'></i> Distributed
                                                    </span>
                                                @else
                                                    <span class="badge bg-warning bg-opacity-10 text-warning rounded-pill px-3 py-2">
                                                        <i class='bx bxs-time me-1'></i> Pending
                                                    </span>
                                                @endif
                                            </td>

                                            @if(auth()->user()->role !== 'donatur' || auth()->id() == $d->user_id)
                                            <td class="text-end pe-4">
                                                <form method="POST" action="{{ route('donations.destroy', $d->id) }}" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus donasi ini?')">
                                                    @csrf @method('DELETE')
                                                    <button class="btn btn-link text-danger p-0 opacity-75 hover-opacity-100" title="Hapus">
                                                        <i class='bx bxs-trash fs-5'></i>
                                                    </button>
                                                </form>
                                            </td>
                                            @endif
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center py-5">
                                                <i class='bx bx-box fs-1 text-muted opacity-25 mb-3'></i>
                                                <p class="text-muted mb-0">Tidak ada data donasi ditemukan.</p>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
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

@endsection