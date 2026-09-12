<h1>Dashboard Invito</h1>

<p>
    Selamat datang, {{ auth()->user()->name }}
</p>

<form method="POST" action="{{ route('logout') }}">
    @csrf

    <button type="submit">
        Logout
    </button>
</form>