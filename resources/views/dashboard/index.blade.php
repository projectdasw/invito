@extends('layouts.dashboard')

@section('title', 'Dashboard')

@section('page-title', 'Dashboard')

@section('content')

    {{-- Welcome --}}
    <div class="mb-4">

        <h2 class="fw-bold mb-1">
            Welcome back, {{ Auth::user()->name }}!
        </h2>

        <p class="text-muted mb-0">
            Here's what's happening with your event today.
        </p>

    </div>


    {{-- Statistics --}}
    <div class="row g-4 mb-4">

        {{-- Total Guests --}}
        <div class="col-md-4">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-body p-4">

                    <div class="d-flex justify-content-between">

                        <div>

                            <p class="text-muted mb-1">
                                Total Guests
                            </p>

                            <h2 class="fw-bold mb-0">
                                250
                            </h2>

                        </div>

                        <div class="text-primary fs-2">

                            <i class="fa-solid fa-users"></i>

                        </div>

                    </div>

                </div>

            </div>

        </div>


        {{-- Checked In --}}
        <div class="col-md-4">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-body p-4">

                    <div class="d-flex justify-content-between">

                        <div>

                            <p class="text-muted mb-1">
                                Checked In
                            </p>

                            <h2 class="fw-bold mb-0">
                                180
                            </h2>

                        </div>

                        <div class="text-success fs-2">

                            <i class="fa-solid fa-user-check"></i>

                        </div>

                    </div>

                </div>

            </div>

        </div>


        {{-- Pending --}}
        <div class="col-md-4">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-body p-4">

                    <div class="d-flex justify-content-between">

                        <div>

                            <p class="text-muted mb-1">
                                Not Checked In
                            </p>

                            <h2 class="fw-bold mb-0">
                                70
                            </h2>

                        </div>

                        <div class="text-warning fs-2">

                            <i class="fa-solid fa-user-clock"></i>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- Main Dashboard Content --}}
    <div class="row g-4">

        {{-- Check-in Progress --}}
        <div class="col-lg-8">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-body p-4">

                    <div class="d-flex justify-content-between align-items-center mb-4">

                        <div>

                            <h5 class="fw-bold mb-1">
                                Check-in Progress
                            </h5>

                            <p class="text-muted mb-0">
                                Guest attendance overview
                            </p>

                        </div>

                        <i class="fa-solid fa-chart-pie fs-3 text-primary"></i>

                    </div>


                    <div class="text-center py-4">

                        <h1 class="display-4 fw-bold">
                            72%
                        </h1>

                        <p class="text-muted">
                            Guests have checked in
                        </p>

                        <div
                            class="progress"
                            style="height: 12px;"
                        >

                            <div
                                class="progress-bar"
                                role="progressbar"
                                style="width: 72%;"
                            ></div>

                        </div>

                    </div>

                </div>

            </div>

        </div>


        {{-- Quick Action --}}
        <div class="col-lg-4">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-body p-4">

                    <h5 class="fw-bold mb-4">
                        Quick Actions
                    </h5>


                    <div class="d-grid gap-3">

                        <a
                            href="#"
                            class="btn btn-primary btn-lg"
                        >

                            <i class="fa-solid fa-qrcode me-2"></i>

                            Scan QR Code

                        </a>


                        <a
                            href="#"
                            class="btn btn-outline-primary"
                        >

                            <i class="fa-solid fa-user-plus me-2"></i>

                            Add Guest

                        </a>


                        <a
                            href="#"
                            class="btn btn-outline-secondary"
                        >

                            <i class="fa-solid fa-clock-rotate-left me-2"></i>

                            View History

                        </a>

                    </div>

                </div>

            </div>

        </div>

    </div>

@endsection