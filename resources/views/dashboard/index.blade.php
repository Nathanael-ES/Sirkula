@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">{{ __('messages.dashboard') }}</h1>

    <div class="row g-3">
        <div class="col-md-3">
            <div class="card shadow-sm p-3">
                <small class="text-muted">{{ __('messages.items') }}</small>
                <h4 class="mt-2">{{ $totalItems ?? 0 }}</h4>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm p-3">
                <small class="text-muted">{{ __('messages.pending') }}</small>
                <h4 class="mt-2">{{ $pending ?? 0 }}</h4>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm p-3">
                <small class="text-muted">{{ __('messages.verified') }}</small>
                <h4 class="mt-2">{{ $verified ?? 0 }}</h4>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm p-3">
                <small class="text-muted">{{ __('messages.ready') }}</small>
                <h4 class="mt-2">{{ $ready ?? 0 }}</h4>
            </div>
        </div>
    </div>

    <div class="row mt-4 g-3">
        <div class="col-md-4">
            <div class="card p-3 shadow-sm">
                <small class="text-muted">{{ __('messages.distribution_list') }}</small>
                <h5 class="mt-2">{{ $totalDistribution ?? 0 }}</h5>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card p-3 shadow-sm">
                <small class="text-muted">{{ __('messages.recipients') }}</small>
                <h5 class="mt-2">{{ $totalRecipients ?? 0 }}</h5>
            </div>
        </div>
    </div>
</div>
@endsection
