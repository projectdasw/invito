@extends('layouts.dashboard')
@section('title', 'Guest Detail')
@section('content')
    <div class="container-fluid">

        {{-- Header --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="fw-bold mb-1">Guest Detail</h4>
                <p class="text-muted mb-0">View guest information</p>
            </div>
            <a href="{{ route('guests.index') }}" class="btn btn-outline-secondary">
                <i class="fa-solid fa-arrow-left me-2"></i>
                Back
            </a>
        </div>

        {{-- Guest Information --}}
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">

                {{-- Guest Header --}}
                <div class="d-flex align-items-center mb-4">
                    <div class="guest-avatar me-3">
                        <i class="fa-solid fa-user"></i>
                    </div>
                    <div>
                        <h5 class="fw-bold mb-1">{{ $guest->name }}</h5>
                        @if ($guest->status === 'checked_in')
                            <span class="badge bg-success">Checked In</span>
                        @else
                            <span class="badge bg-secondary">Pending</span>
                        @endif
                    </div>
                </div>

                {{-- Information --}}
                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="text-muted small mb-1">Guest Name</div>
                        <div class="fw-semibold">{{ $guest->name }}</div>
                    </div>
                    <div class="col-md-6">
                        <div class="text-muted small mb-1">Phone Number</div>
                        <div class="fw-semibold">{{ $guest->no_hp ?: '-' }}</div>
                    </div>
                    <div class="col-md-12">
                        <div class="text-muted small mb-1">Address</div>
                        <div class="fw-semibold">{{ $guest->address ?: '-' }}</div>
                    </div>

                    {{-- QR Code Identifier --}}
                    <div class="col-md-6">
                        <div class="text-muted small mb-1">QR Code</div>
                        <div class="fw-semibold">{{ $guest->qr_code }}</div>
                    </div>

                    {{-- Status --}}
                    <div class="col-md-6">
                        <div class="text-muted small mb-1">Status</div>
                        @if ($guest->status === 'checked_in')
                            <span class="badge bg-success">Checked In</span>
                        @else
                            <span class="badge bg-secondary">Pending</span>
                        @endif
                    </div>

                    {{-- Created --}}
                    <div class="col-md-6">
                        <div class="text-muted small mb-1">Created At</div>
                        <div class="fw-semibold">{{ $guest->created_at->format('d M Y H:i') }}</div>
                    </div>

                    {{-- Updated --}}
                    <div class="col-md-6">
                        <div class="text-muted small mb-1">Last Updated</div>
                        <div class="fw-semibold">{{ $guest->updated_at->format('d M Y H:i') }}</div>
                    </div>
                </div>

                {{-- Actions --}}
                <div class="d-flex justify-content-end gap-2 mt-4 pt-4 border-top">
                    <a href="{{ route('guests.edit', $guest) }}" class="btn btn-warning">
                        <i class="fa-solid fa-pen me-2"></i>
                        Edit Guest
                    </a>
                    <form action="{{ route('guests.destroy', $guest) }}" method="POST" class="delete-guest-form d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="fa-solid fa-trash me-2"></i>
                            Delete Guest
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    @vite('resources/js/guests.js')
@endpush