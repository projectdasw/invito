@extends('layouts.dashboard')
@section('title', 'Scan QR')
@section('content')
    <div class="container-fluid">

        {{-- Header --}}
        <div class="mb-4">
            <h4 class="fw-bold mb-1">Scan QR Code</h4>
            <p class="text-muted mb-0">
                Scan guest QR Code using a scanner or camera.
            </p>
        </div>

        {{-- Scanner Mode --}}
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">

                {{-- Mode Selection --}}
                <div class="d-flex justify-content-center mb-4">
                    <div class="btn-group" role="group" aria-label="Scanner Mode">
                        <button type="button" id="hardwareMode" class="btn btn-primary">
                            <i class="fa-solid fa-barcode me-2"></i>
                            Hardware Scanner
                        </button>
                        <button type="button" id="cameraMode" class="btn btn-outline-primary">
                            <i class="fa-solid fa-camera me-2"></i>
                            Camera
                        </button>
                    </div>
                </div>

                {{-- Hardware Scanner --}}
                <div id="hardwareScanner">
                    <div class="text-center">
                        <div class="mb-4">
                            <i class="fa-solid fa-barcode fa-4x text-primary"></i>
                        </div>
                        <h5 class="fw-bold">Hardware Scanner</h5>
                        <p class="text-muted">
                            Connect your USB or Bluetooth QR scanner,
                            then scan the guest QR Code.
                        </p>
                    </div>
                    <div class="mx-auto" style="max-width: 500px;">
                        <label for="qrScannerInput" class="form-label fw-semibold">Scanner Input</label>
                        <input type="text" id="qrScannerInput" class="form-control form-control-lg text-center"
                            placeholder="Scan QR Code..." autocomplete="off" autofocus>
                        <div class="form-text text-center">
                            The scanner should automatically enter
                            the QR Code value.
                        </div>
                    </div>
                </div>

                {{-- Camera Scanner --}}
                <div id="cameraScanner" class="d-none">
                    <div class="text-center">
                        <div id="qrReader" class="mx-auto" style="max-width: 500px;"></div>
                        <p class="text-muted mt-3 mb-0">
                            Point your camera at the guest QR Code.
                        </p>
                    </div>
                </div>

                {{-- Scan Result --}}
                <div id="scanResult" class="card border-0 shadow-sm d-none" >
                    <div class="card-body">
                        <h5 class="mb-4">
                            <i class="fa-solid fa-user-check me-2"></i>
                            Guest Information
                        </h5>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <small class="text-muted">Nama Tamu</small>
                                <div id="guestName" class="fw-semibold">-</div>
                            </div>
                            <div class="col-md-6">
                                <small class="text-muted">Nomor HP</small>
                                <div id="guestPhone">-</div>
                            </div>
                            <div class="col-md-6">
                                <small class="text-muted">Status</small>
                                <div id="guestStatus">-</div>
                            </div>
                            <div class="col-md-6">
                                <small class="text-muted">
                                    QR Code
                                </small>
                                <div id="scanResultValue" class="font-monospace">-</div>
                            </div>
                            <div class="col-12">
                                <small class="text-muted">
                                    Alamat
                                </small>
                                <div id="guestAddress">-</div>
                            </div>
                            <div class="col-12 mt-3">
                                <button type="button" id="checkInButton" class="btn btn-success">
                                    <i class="fa-solid fa-check me-2"></i>
                                    Check-in Tamu
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    @vite('resources/js/scan.js')
@endpush
