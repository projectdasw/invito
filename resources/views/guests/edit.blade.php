@extends('layouts.dashboard')
@section('title', 'Edit Guest')
@section('content')
    <div class="container-fluid">

        {{-- Header --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="fw-bold mb-1">Edit Guest</h4>
                <p class="text-muted mb-0">Update guest information</p>
            </div>
            <a href="{{ route('guests.index') }}" class="btn btn-outline-secondary">
                <i class="fa-solid fa-arrow-left me-2"></i>
                Back
            </a>
        </div>

        {{-- Form Card --}}
        <div class="card border-0 shadow-sm guest-form-card">
            <div class="card-body p-4">
                <form id="guestForm" action="{{ route('guests.update', $guest) }}" method="POST" novalidate>
                    @csrf
                    @method('PUT')

                    {{-- Name --}}
                    <div class="mb-3">
                        <label for="name" class="form-label fw-semibold">Guest Name</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $guest->name) }}"
                            placeholder="Enter guest name" maxlength="255" required>
                        <div class="invalid-feedback">Guest name is required.</div>
                    </div>

                    {{-- Phone --}}
                    <div class="mb-3">
                        <label for="no_hp" class="form-label fw-semibold">Phone Number</label>
                        <input type="text" class="form-control" id="no_hp" name="no_hp" value="{{ old('no_hp', $guest->no_hp) }}"
                            placeholder="Example: 081234567890" inputmode="numeric" maxlength="15">
                        <div class="invalid-feedback">Phone number can only contain numbers.</div>
                    </div>

                    {{-- Address --}}
                    <div class="mb-3">
                        <label for="address" class="form-label fw-semibold">Address</label>
                        <textarea class="form-control" id="address" name="address" rows="4"
                        placeholder="Enter guest address">{{ old('address', $guest->address) }}</textarea>
                    </div>

                    {{-- QR Code Information --}}
                    <div class="alert alert-light border mb-4">
                        <div class="d-flex align-items-start">
                            <i class="fa-solid fa-qrcode text-primary me-3 mt-1"></i>
                            <div>
                                <div class="fw-semibold mb-1">QR Code</div>
                                <div class="text-muted small">{{ $guest->qr_code }}</div>
                                <small class="text-muted">
                                    QR Code is automatically generated and
                                    cannot be changed from this page.
                                </small>
                            </div>
                        </div>
                    </div>

                    {{-- Buttons --}}
                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('guests.index') }}" class="btn btn-outline-secondary">Cancel</a>
                        <button type="submit" class="btn btn-primary" id="saveGuestButton">
                            <i class="fa-solid fa-save me-2"></i>
                            Update Guest
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    @vite('resources/js/guests.js')
@endpush