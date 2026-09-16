@extends('layouts.dashboard')
@section('title', 'Add Guest')
@section('page-title', 'Add Guest')
@section('content')
    <div class="container-fluid">

        {{-- Header --}}
        <div class="d-flex align-items-center gap-3 mb-4">
            <a href="{{ route('guests.index') }}" class="btn btn-light border">
                <i class="fa-solid fa-arrow-left"></i>
            </a>
            <div>
                <h4 class="fw-bold mb-1">Add Guest</h4>
                <p class="text-muted mb-0">Tambahkan data tamu undangan baru.</p>
            </div>
        </div>

        {{-- Form Card --}}
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <form action="{{ route('guests.store') }}" method="POST" id="guestForm" novalidate>
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label fw-semibold">
                            Nama Tamu
                            <span class="text-danger">*</span>
                        </label>
                        <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror"
                            value="{{ old('name') }}" placeholder="Masukkan nama tamu" maxlength="255" required>

                        <!-- @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror -->

                        <div class="invalid-feedback">
                            Nama tamu wajib diisi.
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="no_hp" class="form-label fw-semibold">Nomor HP</label>
                        <input type="text" name="no_hp" id="no_hp" class="form-control @error('no_hp') is-invalid @enderror"
                            value="{{ old('no_hp') }}" placeholder="Contoh: 081234567890" inputmode="numeric" pattern="[0-9]*" maxlength="15">

                        <!-- @error('no_hp')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror -->

                        <div class="invalid-feedback">
                            Nomor HP hanya boleh berisi angka.
                        </div>
                    </div>
                    <div class="mb-4">
                        <label for="address" class="form-label fw-semibold">Alamat</label>
                        <textarea name="address" id="address" class="form-control @error('address') is-invalid @enderror" rows="4"
                            placeholder="Masukkan alamat tamu">{{ old('address') }}</textarea>

                        @error('address')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="alert alert-info d-flex align-items-start gap-2">
                        <i class="fa-solid fa-circle-info mt-1"></i>
                        <div>
                            <strong>QR Code</strong>
                            <div class="small">
                                QR Code tamu akan dibuat secara otomatis
                                setelah data berhasil disimpan.
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('guests.index') }}" class="btn btn-light border">Cancel</a>
                        <button type="submit" class="btn btn-primary" id="saveGuestButton">
                            <i class="fa-solid fa-floppy-disk me-2"></i>
                            Save Guest
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