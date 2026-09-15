<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        @yield('title', 'Dashboard') | Invito
    </title>

    @vite([
    'resources/css/app.css',
    'resources/css/dashboard.css',
    'resources/css/guests.css',
    'resources/js/app.js'
])

</head>

<body>

<div class="d-flex min-vh-100">

    {{-- Sidebar --}}
    <aside
        class="bg-dark text-white"
        style="width: 250px;"
    >

        {{-- Brand --}}
        <div class="p-4 border-bottom border-secondary">

            <h4 class="mb-0 fw-bold">

                <i class="fa-solid fa-qrcode me-2"></i>

                Invito

            </h4>

            <small class="text-secondary">
                Guest Check-in System
            </small>

        </div>


        {{-- Navigation --}}
        <nav class="p-3">

            <ul class="nav nav-pills flex-column gap-1">

                {{-- Dashboard --}}
                <li class="nav-item">
        <a
            href="{{ route('dashboard') }}"
            class="nav-link text-white {{ request()->routeIs('dashboard') ? 'active' : '' }}"
        >
            <i class="fa-solid fa-gauge-high me-2"></i>
            Dashboard
        </a>
    </li>


                {{-- Guests --}}
                <li class="nav-item">
        <a
            href="{{ route('guests.index') }}"
            class="nav-link text-white {{ request()->routeIs('guests.*') ? 'active' : '' }}"
        >
            <i class="fa-solid fa-users me-2"></i>
            Guests
        </a>
    </li>


                {{-- Scan --}}
                <li class="nav-item">

                    <a
                        href="#"
                        class="nav-link text-white"
                    >

                        <i class="fa-solid fa-qrcode me-2"></i>

                        Scan QR

                    </a>

                </li>


                {{-- Check-in --}}
                <li class="nav-item">

                    <a
                        href="#"
                        class="nav-link text-white"
                    >

                        <i class="fa-solid fa-user-check me-2"></i>

                        Check-in

                    </a>

                </li>


                {{-- History --}}
                <li class="nav-item">

                    <a
                        href="#"
                        class="nav-link text-white"
                    >

                        <i class="fa-solid fa-clock-rotate-left me-2"></i>

                        History

                    </a>

                </li>

            </ul>

        </nav>


        {{-- Sidebar Bottom --}}
        <div class="mt-auto p-3">

            <form
                action="{{ route('logout') }}"
                method="POST"
            >

                @csrf

                <button
                    type="submit"
                    class="btn btn-outline-light w-100"
                >

                    <i class="fa-solid fa-right-from-bracket me-2"></i>

                    Logout

                </button>

            </form>

        </div>

    </aside>


    {{-- Main Content --}}
    <div class="flex-grow-1">

        {{-- Navbar --}}
        <nav class="navbar navbar-light bg-white border-bottom px-4">

            <div>

                <h5 class="mb-0 fw-semibold">

                    @yield('page-title', 'Dashboard')

                </h5>

            </div>


            {{-- User --}}
            <div class="dropdown">

                <button
                    class="btn btn-light dropdown-toggle"
                    type="button"
                    data-bs-toggle="dropdown"
                >

                    <i class="fa-solid fa-circle-user me-1"></i>

                    {{ Auth::user()->name }}

                </button>

                <ul class="dropdown-menu dropdown-menu-end">

                    <li>

                        <span class="dropdown-item-text">

                            <strong>
                                {{ Auth::user()->name }}
                            </strong>

                            <br>

                            <small class="text-muted">
                                {{ Auth::user()->email }}
                            </small>

                        </span>

                    </li>

                    <li>
                        <hr class="dropdown-divider">
                    </li>

                    <li>

                        <form
                            action="{{ route('logout') }}"
                            method="POST"
                        >

                            @csrf

                            <button
                                type="submit"
                                class="dropdown-item text-danger"
                            >

                                <i class="fa-solid fa-right-from-bracket me-2"></i>

                                Logout

                            </button>

                        </form>

                    </li>

                </ul>

            </div>

        </nav>


        {{-- Page Content --}}
        <main class="p-4">

            @yield('content')

        </main>

    </div>

</div>

@stack('scripts')
</body>

</html>