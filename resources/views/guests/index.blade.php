@extends('layouts.dashboard')

@section('title', 'Guest Management')

@section('page-title', 'Guest Management')

@section('content')

<div class="container-fluid">

    {{-- Header --}}
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">

        <div>
            <h4 class="fw-bold mb-1">
                Guest Management
            </h4>

            <p class="text-muted mb-0">
                Kelola data tamu undangan.
            </p>
        </div>

        <a href="{{ route('guests.create') }}" class="btn btn-primary">
            <i class="fa-solid fa-user-plus me-2"></i>
            Add Guest
        </a>

    </div>


    {{-- Guest Table Card --}}
    <div class="card border-0 shadow-sm">

        <div class="card-body">

            {{-- Search & Filter --}}
            <div class="row g-3 mb-4">

                <div class="col-md-6">

                    <div class="input-group">

                        <span class="input-group-text bg-white">
                            <i class="fa-solid fa-magnifying-glass text-muted"></i>
                        </span>

                        <input
                            type="text"
                            id="searchGuest"
                            class="form-control"
                            placeholder="Search guest..."
                        >

                    </div>

                </div>

                <div class="col-md-3">

                    <select id="filterStatus" class="form-select">

                        <option value="">All Status</option>
                        <option value="pending">Pending</option>
                        <option value="checked_in">Checked In</option>

                    </select>

                </div>

            </div>


            {{-- Table --}}
            <div class="table-responsive">

                <table class="table table-hover align-middle mb-0">

                    <thead class="table-light">

                        <tr>

                            <th width="60">No</th>

                            <th>Guest</th>

                            <th>Phone</th>

                            <th>Address</th>

                            <th>Status</th>

                            <th class="text-end">Action</th>

                        </tr>

                    </thead>

                    <tbody id="guestTable">

                        @forelse($guests as $index => $guest)

                            <tr
                                data-name="{{ strtolower($guest->name) }}"
                                data-status="{{ $guest->status }}"
                            >

                                <td>
                                    {{ $guests->firstItem() + $index }}
                                </td>

                                <td>

                                    <div class="d-flex align-items-center gap-3">

                                        <div class="guest-avatar">
                                            <i class="fa-solid fa-user"></i>
                                        </div>

                                        <div>

                                            <div class="fw-semibold">
                                                {{ $guest->name }}
                                            </div>

                                            <small class="text-muted">
                                                {{ $guest->qr_code }}
                                            </small>

                                        </div>

                                    </div>

                                </td>

                                <td>
                                    {{ $guest->no_hp ?? '-' }}
                                </td>

                                <td>
                                    {{ $guest->address ?? '-' }}
                                </td>

                                <td>

                                    @if($guest->status === 'checked_in')

                                        <span class="badge text-bg-success">
                                            <i class="fa-solid fa-circle-check me-1"></i>
                                            Checked In
                                        </span>

                                    @else

                                        <span class="badge text-bg-warning">
                                            <i class="fa-solid fa-clock me-1"></i>
                                            Pending
                                        </span>

                                    @endif

                                </td>

                                <td class="text-end">

                                    <div class="btn-group">

                                        <a
                                            href="{{ route('guests.edit', $guest) }}"
                                            class="btn btn-sm btn-outline-primary"
                                            title="Edit"
                                        >
                                            <i class="fa-solid fa-pen"></i>
                                        </a>

                                        <button
                                            type="button"
                                            class="btn btn-sm btn-outline-danger btn-delete-guest"
                                            data-id="{{ $guest->id }}"
                                            data-name="{{ $guest->name }}"
                                            title="Delete"
                                        >
                                            <i class="fa-solid fa-trash"></i>
                                        </button>

                                    </div>

                                    <form
                                        id="delete-form-{{ $guest->id }}"
                                        action="{{ route('guests.destroy', $guest) }}"
                                        method="POST"
                                        class="d-none"
                                    >
                                        @csrf
                                        @method('DELETE')
                                    </form>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="6" class="text-center py-5">

                                    <div class="text-muted">

                                        <i class="fa-solid fa-users fa-2x mb-3"></i>

                                        <p class="mb-0">
                                            Belum ada data tamu.
                                        </p>

                                    </div>

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>


            {{-- Pagination --}}
            @if($guests->hasPages())

                <div class="mt-4">

                    {{ $guests->links() }}

                </div>

            @endif

        </div>

    </div>

</div>

@endsection
@push('scripts')
    @vite('resources/js/guests.js')
@endpush